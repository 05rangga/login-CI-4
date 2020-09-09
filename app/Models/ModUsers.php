<?php namespace App\Models;

use CodeIgniter\Model;

class ModUsers extends Model
{
    protected $table = "users";
    protected $primaryKey = 'user_id';

	public function __construct()
	{
    }

}