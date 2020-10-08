<?php

namespace Lit\Core\Entities;

use Illuminate\Database\Eloquent\Model;

class Crud extends Model
{
    public $table = 'cruds';

    protected $fillable = ['table_name', 'config'];

    protected $casts = [
        'config' => 'json'
    ];
}
