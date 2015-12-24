<?php

use Illuminate\Database\Eloquent\Model;

class Student extends Model {

	//
	public $timestamps = false;
	protected $table = 'students';
	protected $fillable = ['college','faculty','name','rollno','course','semester','gender','food'];

}
