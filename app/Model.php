<?php

namespace App;

use SamWrigley\Support\Traits\HasPaths;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    use HasPaths;
}
