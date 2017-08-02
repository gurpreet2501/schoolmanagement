<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;
class AccountCategories extends Model
{   
    public $timestamps = false;
    protected $table    = 'account_categories';
    protected $fillable = ['name'];
}
