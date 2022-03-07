<?php

namespace Navarr;

use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;
use Stringable;

class SmartStringFactory
{
    #[Pure]
    public function create(Stringable|string $value): SmartString
    {
        return SmartString::build($value);
    }
}
