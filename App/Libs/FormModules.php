<?php /**
* 
*/
namespace App\Libs;
class FormModules
{
	
	function __construct($data)
	{
			auth_force();
			$this->data = $data;	
	}

	function hasModule($modId){
		
		foreach ($this->data->modules as $key => $module){ 
			 if($module->module_id == $modId){
			 	return true;
			 	break;
			 }
		}
		return false;

	}

	function getStockGroupIds($modId){
		 
		 $stockGroupIds = [];

			foreach ($this->data->modules as $key => $module){
			 if($module->module_id == $modId){
					foreach ($module->stockGroups as $key => $stkGrp) {
						$stockGroupIds[] = $stkGrp->id;
					}
			 }
		}
 
 	 return $stockGroupIds;
	}

	function getStockItemIds($modId){
		
		 $stockItemIds = [];
		
			foreach ($this->data->modules as $key => $module){
			 if($module->module_id == $modId){
					foreach ($module->stockItems as $key => $stkItem) {
						$stockItemIds[] = $stkItem->id;
					}
			 }
		}
 
 	 return $stockItemIds;
	}

	function getJobCategoryIds($modId){
		
		 $jobCategoryIds = [];
		
			foreach ($this->data->modules as $key => $module){
			 if($module->module_id == $modId){
					foreach ($module->labourJobCategories as $key => $jobCat) {
						$jobCategoryIds[] = $jobCat->id;
					}
			 }
		}
		
 	 return $jobCategoryIds;
	}


	function getQualityCutIds($modId){
		
		 $qualityCutIds = [];
		 	foreach ($this->data->modules as $key => $module){
			 if($module->module_id == $modId){
					foreach ($module->qualityCutTypes as $key => $quallityCut) 
						$qualityCutIds[] = $quallityCut->id;
				
			 }
		}

 	 return $qualityCutIds;
	}

} 
