<?php

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model {

	//
	public $timestamps = false;
	protected $table = 'faculty';
	protected $fillable = ['college','name','designation','interest','gender','food'];

}
