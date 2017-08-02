<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class CustomLabourJobs extends Model
{
	protected $table    = 'custom_labour_jobs';
    protected $fillable = ['job_name','godown_id','remarks','amount','party_id','date'];
  
}