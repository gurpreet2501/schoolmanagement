<?php

namespace Models;
use Illuminate\Database\Eloquent\Model;

class GEQualityCuts extends Model
{
    protected $table    = 'ge_quality_cut';
    protected $fillable = ['ge_id',
							'quality_cut_type',
							'bags',
							'qty_per_bag',
							'remarks'];
}