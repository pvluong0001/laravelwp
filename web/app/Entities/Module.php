<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Module.
 *
 * @package namespace App\Entities;
 *
 * @property string $name
 * @property string $config JSON
 * @property bool $activated
 * @property string $hash
 */
class Module extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'config', 'activated', 'hash'];

    protected $casts = [
        'name'    => 'string',
        'config'  => 'json',
        'activated' => 'boolean',
        'hash'    => 'string'
    ];
}
