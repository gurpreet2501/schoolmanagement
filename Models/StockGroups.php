<?php
namespace Models;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Model;

class StockGroups extends Model
{

    public $timestamps  = false;
    protected $table    = 'stock_groups';

    function gateEntryConfig(){
    	return $this->hasMany(GateEntryConfig::class,'stock_group_id');
    }

    function hasGateEntryModule($moduleId){
    	return  (Boolean) $this->gateEntryConfig->filter(function($configItem) use ($moduleId){
    		return ($moduleId == $configItem->module_id);
    	})
    	->count();   
    }

    function stockItems(){
        return $this->hasMany(StockItems::class,'stock_group_id');
    }

    function geBagTypes(){
        return $this->hasMany(GEBagTypes::class,'bag_type_id');
    }

    function balanceTill($date){
       
        $data = [];
        $total = 0;
        $stockGroupTotal = 0;
        $bagTypesTotal = 0;
        $stockItemsTotalIn = 0;
        $stockItemsTotalOut = 0;
        $date = $date.' 23:59:59';  
        $manualOpeningStock = $this->manualOpeningStock($date);
        
        $resultOut = DB::select("
            SET FOREIGN_KEY_CHECKS = 0;
            select sum(bags) as bags from stock_items 
            left join `ge_stock_items` on stock_items.id=ge_stock_items.stock_item_id
            left join `gate_entries` on ge_stock_items.ge_id=gate_entries.id
            where stock_items.stock_group_id=".$this->id." 
            AND 
            gate_entries.entry_type='OUT' 
            AND  
            gate_entries.second_weight_date <= '".$date."';
            SET FOREIGN_KEY_CHECKS = 1;
            ");
        
      
        $stockItemsTotalOut = $stockItemsTotalOut + $resultOut[0]->bags;
          
        $resultIn = DB::select("
            SET FOREIGN_KEY_CHECKS = 0;
            select sum(bags) as bags from stock_items 
            left join `ge_stock_items` on stock_items.id=ge_stock_items.stock_item_id
            left join `gate_entries` on ge_stock_items.ge_id=gate_entries.id
            where stock_items.stock_group_id=".$this->id." AND gate_entries.entry_type='IN' AND  
            gate_entries.first_weight_date <= '".$date."';
            SET FOREIGN_KEY_CHECKS = 1;
            ");

       
        $stockItemsTotalIn = $stockItemsTotalIn + $resultIn[0]->bags;
      
        return $stockItemsTotalIn - $stockItemsTotalOut + $manualOpeningStock;

    }

    function openingStock($date){
     
      $date = date('Y-m-d', strtotime($date . ' -1 day'));
     
      return $this->balanceTill($date);
    }

    function manualOpeningStock($date){
     
      $os = DB::select(
        "select sum(opening_stock) as os from stock_items where stock_group_id=".$this->id." 
        AND 
        opening_stock_date <= '".$date."'
        AND 
        opening_stock_date != '0000-00-00 00:00:00'"
        );
      
      return $os[0]->os;
    }

    function closingStock($date){
      return $this->balanceTill($date);
    }

    function bagWeights(){
        return $this->hasMany(BagWeights::class,'stock_item_id');
    }

    function qualityCutTypes(){
        return $this->hasMany(QualityCutTypes::class,'stock_group_id');
    }

    function bagTypes(){
        return $this->belongsToMany(BagTypes::class, 'stock_groups_bag_types', 'stock_group_id', 'bag_type_id');
    }

    function stockGroupCategories(){
        return $this->belongsToMany(StockGroupCategories::class, 'stock_group_categories_relation', 'stock_group_id', 'stock_group_categories_id');
    }

    function scopeWhereCategory($query, $cat){
        return $query->whereHas('stockGroupCategories', function ($query) use ($cat) {
             $query->where('name', $cat);
        });
    }

    function forms()
    {
        return $this->hasOne(Forms::class, 'id', 'form_id');
    }
}
