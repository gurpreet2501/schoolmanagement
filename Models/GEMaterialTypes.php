<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class GEMaterialTypes extends Model
{
	protected $table    = 'ge_material_types';
    protected $fillable = ['ge_id',
    						'material_type_id',
							'bags'];
}