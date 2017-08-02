<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class GEGodownLaborAllocation extends Model
{
    protected $table    = 'ge_godown_labor_allocation';
    protected $fillable = ['godown_id',
    						'job_status',
    						'bags',
    						'labor_party_name',
    						'remarks'];

}
