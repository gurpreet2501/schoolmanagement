<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;
class AccountCategoriesRelation extends Model
{   
    public $timestamps = false;
    protected $table    = 'accounts_categories_relation';
    protected $fillable = ['account_id','account_category_id'];
}
