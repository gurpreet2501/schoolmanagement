<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class FormModulesQualityCutTypes extends Model
{
	protected $table    = 'form_modules_quality_cut_types';
  protected $fillable = ['form_modules_id','quality_cut_types_id'];
  
}