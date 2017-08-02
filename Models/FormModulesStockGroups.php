<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class FormModulesStockGroups extends Model
{
	protected $table    = 'form_modules_stock_groups';
  protected $fillable = ['form_modules_id','stock_groups_id'];
  
}