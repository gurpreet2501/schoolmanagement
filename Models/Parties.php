<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class Parties extends Model
{
	protected $table    = 'parties';
    protected $fillable = ['name','fields'];
}