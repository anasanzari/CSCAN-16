<?php
namespace App;
require_once "College.php";
use Illuminate\Database\Eloquent\Model;


class Faculty extends Model {

	//
	public $timestamps = false;
	protected $table = 'faculty';
	protected $fillable = ['regid','college','name','email','phone','designation','interest','gender','food'];

	public function colg(){
			return $this->belongsTo("App\College",'college');
	}

}
