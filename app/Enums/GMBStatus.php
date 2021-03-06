<?php

namespace App\Enums;

use BenSampo\Enum\Enum;
use Str;

/**
 * @method static static pending()
 * @method static static approved()
 * @method static static rejected()
 */
final class GMBStatus extends Enum
{
    public const pending = 0;
    public const approved = 1;
    public const rejected = 2;

    public function toArray(): string
    {
        return Str::snake($this->description);
    }
}
