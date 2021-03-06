<?php

namespace App\Enums;

use BenSampo\Enum\Enum;
use Str;

/**
 * @method static static ScheduleOfficer()
 * @method static static CommunityManager()
 * @method static static Executive()
 */
final class StateMembershipType extends Enum
{
    public const ScheduleOfficer = 0;
    public const CommunityManager = 1;
    public const Executive = 2;

    public function toArray(): string
    {
        return Str::slug($this->description);
    }
}
