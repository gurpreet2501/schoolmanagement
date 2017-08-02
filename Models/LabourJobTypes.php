<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class LabourJobTypes extends Model
{
	protected $table    = 'labour_job_types';
    protected $fillable = [];

    function parties(){
    	return $this->belongsToMany(Accounts::class,
    						'labour_party_job_types',
    						'labour_job_type_id',
    						'account_id');
    }


    function labourPartyJobTypes(){
        return $this->hasOne(LabourPartyJobTypes::class, 'labour_job_type_id', 'id');
    }

    function labourJobCategory(){
    	return $this->hasOne(LabourJobCategories::class, 'id', 'labour_job_category_id');
    }
  
}