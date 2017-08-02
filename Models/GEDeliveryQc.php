<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class GEDeliveryQc extends Model
{
    protected $table    = 'ge_delivery_qc';
    protected $fillable = ['cut_unit','gate_entry_id','qc_type_id','quantity_per_unit','unit_count'];

    function saveDelieveryQc($delDetails,$gateEntryId){
    	foreach($delDetails as $key => $delievery){
    		$delievery['gate_entry_id'] =	$gateEntryId;
	    	$this->create($delievery);
    	}

    }

}
