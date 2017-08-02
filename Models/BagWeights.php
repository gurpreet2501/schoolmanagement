<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class BagWeights extends Model
{
    protected $table    = 'bag_weights';
    public $timestamps = false;
    protected $fillable    = ['weight','weight_unit','stock_item_id'];

}
