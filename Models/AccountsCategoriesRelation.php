<?php

namespace Models;
use Illuminate\Database\Eloquent\Model;

class AccountsCategoriesRelation extends Model
{   
    public $timestamps = false;
    protected $table    = 'accounts_categories_relation';
    protected $fillable = ['account_id','account_category_id'];

    function accounts()
    {
    	return $this->hasOne(Accounts::class, 'id', 'account_id');   
    }

            



}
