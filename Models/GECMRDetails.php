<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class GECMRDetails extends Model
{
    protected $table    = 'ge_cmr_details';
    protected $fillable = ['account_id','cmr_agency_id','cmr_market_id','truck_no','tp_no','tp_date','ac_note_no','ac_note_date','quintals','no_of_bags','m_serial_no'];


    function market()
    {
    	return $this->hasOne(CMRMarkets::class, 'id', 'cmr_market_id');
    }




}
