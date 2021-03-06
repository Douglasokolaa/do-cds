<?php

namespace App\Enums;

use BenSampo\Enum\Enum;
use Str;

/**
 * @method static static Exco()
 */
final class ProjectMemberType extends Enum
{
    public const Exco = 1;

    public function toArray()
    {
        return Str::snake($this->description);
    }
}
