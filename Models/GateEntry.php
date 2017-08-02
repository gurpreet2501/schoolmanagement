<?php

namespace Models;
use Illuminate\Database\Eloquent\Model;

class GateEntry extends Model
{
    protected $table    = 'gate_entries';
    protected $fillable = [	
    					'entry_type',
    					'form_id',
    					'stock_group_id',
							'account_id',
							'loaded_weight',
							'loaded_weight_time',
							'tare_weight',
							'tare_weight_time',
							'gross_weight',
							'packing_material_weight',
							'net_weight',
							'truck_no',
							'chatni_report_no',
							'deduct_packing_material',
							'gate_pass_no'];

  function saveCommonData($data){
    	//take care of 
    	if(isset($data['tare_weight']))
    		$data['tare_weight_time'] = $this->perdictTareWeightTime($data['tare_weight']);
    	if(isset($data['loaded_weight']))
    		$data['loaded_weight_time'] = $this->perdictLoadedWeightTime($data['loaded_weight']);
		$this->fill($data)->save();
		
	}

	private function perdictTareWeightTime($tareWeight){
		if(round($tareWeight,2) == round($this->tare_weight,2))
			return $this->tare_weight_time;
		return date('Y-m-d H:i:s');
	}

	private function perdictLoadedWeightTime($loadedWeight){
		if(round($loadedWeight,2) == round($this->loaded_weight,2))
			return $this->loaded_weight_time;
		return date('Y-m-d H:i:s');		
	}


	function completeStatus(){
		$this->status = 'Complete';
		$this->save();
	}

	function setSecondWeightDate(){
		$this->second_weight_date = date('Y-m-d H:i:s');
		$this->save();
	}

	function setFirstWeightDate(){
		$this->first_weight_date = date('Y-m-d H:i:s');
		$this->save();
	}

	function accounts(){
		return $this->belongsTo(Accounts::class,'account_id');
	}

	function materialTypes(){
		return $this->hasMany(GEMaterialTypes::class,'ge_id');
	}

	function saveMaterialTypes($types){
		$this->materialTypes()->delete();
		foreach($types as $typeId => $bags)
			$this->materialTypes()
					->create([
						'material_type_id' 	=> $typeId,
						'bags'				=> $bags
					]);
	}

	function bagTypes(){
		return $this->hasMany(GEBagTypes::class, 'ge_id');
	}

  	function stockItems(){
		return $this->hasMany(GEStockItems::class,'ge_id');
	}

	function saveBagTypes($types){
		
		$originalTypeIds = [];
		$actualTypeIds = [];
		
		foreach($types as $typeId => $bags){
			$originalTypeIds[] = $typeId;

			if(!$bags)
				continue;

			$actualTypeIds[] = $typeId;
			$exists = $this->bagTypes()->where('ge_id',$this->id)->where('bag_type_id', $typeId)->first();
			
			if(count($exists)){
				$this->bagTypes()->where('ge_id', $this->id)->where('bag_type_id', $typeId)
				->update([
					'bags' => $bags
				]);		
			}else{	
				$this->bagTypes()
					->create([
						'bag_type_id' 	=> $typeId,
						'bags'			=> $bags
					]);
			}		

		 }
		 
		$invalidEntry =  array_diff($originalTypeIds, $actualTypeIds);
		if(count($invalidEntry))
			$this->bagTypes()->where('bag_type_id',$invalidEntry)->delete();

	}

	function saveStockItems($types){
		
		$originalTypeIds = [];
		$actualTypeIds = [];
		
		foreach($types as $typeId => $bags){
			$originalTypeIds[] = $typeId;

			if(!$bags)
				continue;

			$actualTypeIds[] = $typeId;
			$exists = $this->stockItems()->where('ge_id', $this->id)->where('stock_item_id', $typeId)->first();
			
			if(count($exists)){
				
				$this->stockItems()->where('ge_id', $this->id)->where('stock_item_id', $typeId)
				->update([
					'bags'			=> $bags
				]);	

		  	}else{	
				$this->stockItems()
						->create([
							'stock_item_id' 	=> $typeId,
							'bags'			=> $bags
					]);
				}		

		}
		 
		$invalidEntry =  array_diff($originalTypeIds, $actualTypeIds);
		if(count($invalidEntry))
			$this->stockItems()->where('stock_item_id',$invalidEntry)->delete();



	}

	function updateRateContractsInStockItems($rate_contracts,$ge_id){
       
		foreach($rate_contracts as $rc){
			foreach($rc as $v){
				
				$geStockItemObj = GEStockItems::where('ge_id',$ge_id)->where('stock_item_id', $v['contracts_stock_items'][0]['stock_item_id'])->first();
				
			 	 $geStockItemObj->rate_contract_id = $v['contracts_stock_items'][0]['contract_id'];
			 	 $geStockItemObj->rate = $geStockItemObj->bags * $v['contracts_stock_items'][0]['rate'];
			 	 $geStockItemObj->update();
				
			}
			
		}
		
	}

	function getPurchaseAccId($stockItemId){
		$stockItem = StockItems::select('stock_group_id')->where('id', $stockItemId)->first();
		$stGrpId = !empty($stockItem->stock_group_id) ? $stockItem->stock_group_id : 0;
		$stockGrp = StockGroups::select('purchase_account_id')->where('id', $stGrpId)->first();
		$primaryAccId = !empty($stockGrp->purchase_account_id) ? $stockGrp->purchase_account_id : 0;
		return $primaryAccId;
	}

	function getSalesAccId($stockItemId){
		$stockItem = StockItems::select('stock_group_id')->where('id', $stockItemId)->first();
		$stGrpId = !empty($stockItem->stock_group_id) ? $stockItem->stock_group_id : 0;
		$stockGrp = StockGroups::select('sales_account_id')->where('id',$stGrpId)->first();
		$salesAccId = !empty($stockGrp->sales_account_id) ? $stockGrp->sales_account_id : 0;
		return $salesAccId;
	}

	function saveTransactions($types,$entry_type){

	  foreach($types as $stockItemId => $bags){
	  	if(!$bags)
	  		continue;
	  		if($entry_type == 'IN')	
				Transactions::create([
					'entry_type' => 'MATERIAL_IN',
					'transaction_type' => 'CREDIT',
					'transaction_date' => date('Y-m-d H:i:s'),
					'amount' => $bags,
					'primary_account_id' => $this->account_id,
					'secondary_account_id' => $this->getPurchaseAccId($stockItemId) //@param Stock Item Id
			    ]);	
			else
				Transactions::create([
					'entry_type' => 'MATERIAL_OUT',
					'transaction_type' => 'DEBIT',
					'transaction_date' => date('Y-m-d H:i:s'),
					'amount' => $bags,
					'primary_account_id' => $this->account_id,
					'secondary_account_id' => $this->getSalesAccId($stockItemId) //@param Stock Item Id
			    ]);	

     }
	}

	function qualityCuts(){
		return $this->hasMany(GEQualityCuts::class,'ge_id');	
	}

	function saveQualityCuts($qualityCuts){
		$this->qualityCuts()->delete();
		foreach($qualityCuts as $qualityCut)
		$this->qualityCuts()
				->create($qualityCut);
	}

	function godownLaborAllocation(){
		return $this->hasMany(GEGodownLaborAllocation::class,'ge_id');	
	}

	function godownQcLaborAllocation(){
		return $this->hasMany(GEGodownQcLaborAllocation::class,'ge_id');	
	}

	function saveGodownLaborAllocation($data){
		
		$this->godownLaborAllocation()->delete();
		$this->godownLaborAllocation()
			->create($data);
	}

	function saveGodownQcLaborAllocation($data){
	
		$this->godownQcLaborAllocation()->delete();
		foreach ($data as $key => $value) {
			$this->godownQcLaborAllocation()
				->create($value);
		}
	}

	function cmrDetails(){
		return $this->hasMany(GECMRDetails::class,'ge_id');
	}

	function saveCMRDetails($data){
		$this->cmrDetails()->delete();
		if(!$data['cmr_market_id'])
			unset($data['cmr_market_id']);

		$this->cmrDetails()->create($data);
	}

	function cmrRiceDeliveryDetails(){
		return $this->hasMany(GECMRRiceDeliveryDetails::class,'ge_id');
	}

	function saveCMRRiceDeliveryDetails($data){
		$this->cmrRiceDeliveryDetails()->delete();
		$this->cmrRiceDeliveryDetails()->create($data);
	}
}
