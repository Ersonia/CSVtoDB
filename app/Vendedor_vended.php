<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Vendedor_vended extends Eloquent
{
    protected $connection = 'mysql2';

    protected $table = 'VENDED';
    public $timestamps = false;
}
