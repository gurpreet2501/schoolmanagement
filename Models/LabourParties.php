<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class LabourParties extends Model
{
	  protected $table    = 'labour_partes';
    protected $fillable = ['name','fields'];

    function labourJobTypes(){
    	return $this->belongsToMany(LabourJobTypes::class, 'labour_party_job_types', 'labour_party_id', 'labour_job_type_id');
    }
}