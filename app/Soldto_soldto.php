<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Soldto_soldto extends Model
{
    protected $table = 'SOLDTO';
    protected $connection = 'mysql2';
    public $timestamps = false;
}
