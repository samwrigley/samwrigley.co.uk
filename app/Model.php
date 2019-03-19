<?php

namespace App;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use SamWrigley\Support\Traits\HasPaths;

class Model extends EloquentModel
{
    use HasPaths;
}
