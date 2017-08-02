<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class FormModulesLabourJobCategories extends Model
{
	protected $table    = 'form_modules_labour_job_categories';
  protected $fillable = ['form_modules_id','labour_job_categories_id'];
  
  
}