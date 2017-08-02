<?php

namespace Models;
use Illuminate\Database\Eloquent\Model;

class Forms extends Model
{
    protected $table    = 'forms';
    protected $fillable = ['name', 'stock_group_id','type'];

    public function gateEntryConfig()
    {
        return $this->hasMany(GateEntryConfig::class, 'form_id');   
    }

    public function modules()
    {   
    	return $this->hasMany(FormModules::class, 'form_id');	
    }

    function hasGateEntryModule($moduleId){
    	return  (Boolean) $this->gateEntryConfig->filter(function($configItem) use ($moduleId){
    		return ($moduleId == $configItem->module_id);
    	})
    	->count();   
    }

}
