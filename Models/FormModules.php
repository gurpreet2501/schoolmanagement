<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class FormModules extends Model
{
	protected $table    = 'form_modules';
  protected $fillable = ['module_id','form_id'];
  
  public function stockGroups()
    { 
      return $this->belongsToMany(StockGroups::class, 'form_modules_stock_groups', 'form_modules_id', 'stock_groups_id');
    } 

    public function stockItems()
    { 
    	return $this->belongsToMany(StockItems::class, 'form_modules_stock_items', 'form_modules_id', 'stock_item_id');
    } 

  public function labourJobCategories()
    { 
      return $this->belongsToMany(LabourJobCategories::class, 'form_modules_labour_job_categories', 'form_modules_id', 'labour_job_categories_id');
    } 

    public function qualityCutTypes()
    { 
    	return $this->belongsToMany(QualityCutTypes::class, 
                                'form_modules_quality_cut_types', 
                                'form_modules_id', 
                                'quality_cut_types_id');

    } 
}