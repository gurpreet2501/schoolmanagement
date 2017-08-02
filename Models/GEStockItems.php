<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class GEStockItems extends Model
{
    protected $table = 'ge_stock_items';
    protected $fillable = ['ge_id','stock_item_id','bags','rate_contract_id','rate'];

     function gateEntry(){
     	return $this->belongsTo(GateEntry::class, 'ge_id', 'id');
    }
}
