<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class GEBranQualityReport extends Model
{
    protected $table    = 'ge_bran_quality_report';
    protected $fillable = [
    'party_test_report',
    'lab_test_report',
    'disputed',
    'remarks',
    ];

    function saveData($branReportData){
	    	$this->create($branReportData);
    }

}
