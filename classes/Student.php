<?php
namespace App;
require_once "College.php";
use Illuminate\Database\Eloquent\Model;

class Student extends Model {

	//
	public $timestamps = false;
	protected $table = 'students';
	protected $fillable = ['regid','college','faculty','name','email','phone','course','semester','gender','food'];

	public function colg(){
			return $this->belongsTo("App\College",'college');
	}

}
