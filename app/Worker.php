<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $fillable = [
		'last_name',
		'first_name',
		'patronymic',
		'birth_year',
		'post',
		'wages_per_year'
	];
	
	public $timestamps = false;
}
