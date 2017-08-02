<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class RateContractStockItems extends Model
{
    protected $fillable = [
        'contract_id',
        'stock_item_id',
        'rate',
    ];

    public static function contractsStockItems()
    {
    	return self::where('transaction_type', 'DEBIT')->sum('amount');
    }
}
