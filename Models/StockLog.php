<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    protected $table = 'stock_log';
    protected $fillable = ['stock_item_id','stock'];

    function stockLog(){
    	return $this->hasMany(StockLog::class, 'stock_item_id', 'id');
    }
}
