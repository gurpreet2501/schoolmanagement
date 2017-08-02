<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class GECMRRiceDeliveryDetails extends Model
{
    protected $table    = 'ge_cmr_rice_delivery_details';
    protected $fillable = ['cmr_agency_id',
    						'delivery_to_id',
    						'fci_godown_id',
    						'lot_num'];

}
