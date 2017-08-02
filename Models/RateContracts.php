<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class RateContracts extends Model
{
    protected $fillable = [
        'account_id',
        'from_date',
        'stock_group_id',
        'quantity',
        'to_date',
    ];

    public function contractsStockItems()
    {
        return $this->hasMany(RateContractStockItems::class, 'contract_id', 'id');
    }

     function scopeWhereStockItemId($query, $id){
        return $query->whereHas('contractsStockItems', function ($query) use ($id) {
             $query->where('stock_item_id', $id);
        });
    }
}
