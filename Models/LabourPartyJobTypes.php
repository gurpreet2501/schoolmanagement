<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class LabourPartyJobTypes extends Model
{
	public $timestamps = false;
	protected $table    = 'labour_party_job_types';
	protected $fillable = ['account_id','labour_job_type_id','rate'];
  

  function labourJobTypes(){
  	return $this->hasOne(LabourJobTypes::class, 'id', 'labour_job_type_id');
  }
}