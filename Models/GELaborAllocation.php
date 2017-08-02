<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class GEGodownQcLaborAllocation extends Model
{
    protected $table    = 'ge_material_qc_labour_allocation';
    protected $fillable = ['stock_item_id',
    						'godown_id',
    						'labour_party_id',
    						'quality_cut_id',
    						'remarks',
    						'bags',
    						'labour_job_type_id','rate_per_unit','weight_unit'];

  public function stockItems(){
  	return $this->belongsTo(StockItems::class, 'stock_item_id', 'id');
  }

}
