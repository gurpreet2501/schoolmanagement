<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class GEDeliveryDetails extends Model
{
    protected $table    = 'ge_delivery_details';
    protected $fillable = ['weight','gate_entry_id','weight_diff'];

    function saveDelieveryDetails($data){
    	$this->create($data);
    }

}
