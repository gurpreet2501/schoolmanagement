<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class OtherLabourJobs extends Model
{
	protected $table    = 'other_labour_jobs';
    protected $fillable = ['job_type_id','godown_id','weight','weight_unit','party_id','date'];
  
}