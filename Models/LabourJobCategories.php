<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class LabourJobCategories extends Model
{
	protected $table    = 'labour_job_categories';
    protected $fillable = [];

     function labourJobTypes()
     {
        return $this->hasMany(LabourJobTypes::class,'labour_job_category_id');
    }

    function jobTypes(){
    	return $this->hasMany(LabourJobTypes::class,'labour_job_category_id');
    }
  
}