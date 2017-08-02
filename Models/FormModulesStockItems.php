<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class FormModulesStockItems extends Model
{
  protected $table    = 'form_modules_stock_items';
  protected $fillable = ['form_modules_id','stock_item_id'];
  
}