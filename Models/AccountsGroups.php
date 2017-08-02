<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class AccountsGroups extends Model
{
	protected $table    = 'accounts_group';
	protected $fillable = ['name','group_id','category_id'];

	public function accounts()
    {
        return $this->hasMany(Accounts::class, 'accounts_group_id', 'id');
    }
}