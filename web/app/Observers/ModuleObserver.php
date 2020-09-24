<?php

namespace App\Observers;

use App\Entities\Module;
use Ramsey\Uuid\Uuid;

class ModuleObserver
{
    public function creating(Module $module) {
        $module->hash = Uuid::uuid4();
    }
}
