<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Module.
 *
 * @package namespace App\Entities;
 *
 * @property string $name
 * @property string $config JSON
 * @property bool $enabled
 * @property string $hash
 */
class Module extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'config', 'enabled', 'hash'];

    protected $casts = [
        'name'    => 'string',
        'config'  => 'json',
        'enabled' => 'boolean',
        'hash'    => 'string'
    ];
}
