<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model
{ 
    protected $table    = 'user_access';
    protected $fillable    = ['role','feature'];
    public $timestamps = false;
}
