<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
	protected $table    = 'accounts';
  protected $fillable = ['name','accounts_group_id','ob_date','ob_amount','balance_type','gate_entry'];


  function accountCategories(){
  	 return $this->belongsToMany(AccountCategories::class, 'accounts_categories_relation', 'account_id', 'account_category_id');
  }

  function scopeWhereLabourParty($query,$party_name){
    return $query->whereHas('accountCategories', function ($query) use ($party_name) {
           $query->where('name', $party_name);
      });
  } 

  function scopeWhereGroupName($query,$groups){
  	return $query->whereHas('accountGroups', function ($query) use ($groups) {
	   			 $query->whereIn('name', $groups);
			});
  }	

   public function accountGroups()
    {
        return $this->belongsTo(AccountsGroups::class, 'accounts_group_id', 'id');
    }

  public function laborPartyJobTypes()
    {
        return $this->hasMany(LabourPartyJobTypes::class, 'account_id', 'id');
    }



}