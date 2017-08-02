<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class GateEntryConfig extends Model
{
    protected $table    = 'gate_entry_config';
    protected $fillable = ['module_id'];
}
