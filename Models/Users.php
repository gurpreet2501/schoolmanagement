<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{ 
	  const CREATED_AT = 'created';
    protected $table    = 'users';
    protected $fillable    = ['username', 'password','role', 'activated', 'email'];

}
