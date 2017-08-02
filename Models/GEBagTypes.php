<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class GEBagTypes extends Model
{
    protected $table = 'ge_bag_types';
    protected $fillable = ['ge_id','bag_type_id','bags'];

}
