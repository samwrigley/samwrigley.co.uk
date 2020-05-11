<?php

namespace App\Schemas\Contracts;

use Spatie\SchemaOrg\BaseType;

interface SchemaContract
{
    public function generate(): BaseType;
}
