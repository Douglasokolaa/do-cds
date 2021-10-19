<?php

namespace App\Models;

use App\Enums\ProspectStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Prospect extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'email',
        'nysc_state_code',
        'verify_token',
        'state_code',
        'intro_video',
        'status'
    ];

    protected $casts = [
        'status' => ProspectStatus::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
