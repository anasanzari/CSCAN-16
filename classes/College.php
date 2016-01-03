<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class College extends Model {

	//
	public $timestamps = false;
	protected $table = 'colleges';
	protected $fillable = ['name','abbr'];

}
