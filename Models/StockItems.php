<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class StockItems extends Model
{
    protected $table    = 'stock_items';
    protected $fillable    = ['name','stock_group_id'];


    function stockLog(){
    	return $this->hasMany(StockLog::class, 'stock_item_id', 'id');
    }

    function geStockItems(){
    	return $this->hasMany(GEStockItems::class, 'stock_item_id', 'id');
    }

    function scopeAddStock($query,$stock){

      $this->stockLog()->create(['stock' => $stock]);
    	
    }

    function scopeReduceStock($query,$stock){
    	 $this->stockLog()->create(['stock' => ($stock * -1)]);
    }

    function scopeOpeningStock($query,$date){
		
			$total = 0.00;
			$date = date('Y-m-d 23:59:59', strtotime($date . ' -1 day'));

			$stock = $this->stockLog()->where('created_at', '<=', $date)->get();

			foreach ($stock as $key => $val) 
				$total = $total + $val->stock;

			if($this->opening_stock_date <= $date)
				$total = $total +$this->opening_stock;

			return $total;

    }

  function scopeClosingStock($query,$date){
	
		$total = 0.00;

		$stock = $this->stockLog()->where('created_at', '<=', $date)->get();
		foreach ($stock as $key => $val) 
			$total = $total + $val->stock;

		if($this->opening_stock_date <= $date)
			$total = $total +$this->opening_stock;

		return $total;

  }

  function scopeStockTotal($query,$from,$to){

		$total = 0.00;

		$stock = $this->stockLog()->where('created_at', '>=', $from)
												      ->where('created_at', '<=', $to)	
															->get();
										
		foreach ($stock as $key => $val) 
			$total = $total + $val->stock;

		return $total;

  }
}
