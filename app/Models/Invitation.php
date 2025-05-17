<?php

namespace App\Models;

use App\Enums\InvitationGroupType;
use App\Enums\InvitationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'group_type',
        'status',
        'token',
        'sent_at',
        'send_count',
        'invited_by',
        'accepted_at',
    ];

    protected $casts = [
        'group_type' => InvitationGroupType::class,
        'status' => InvitationStatus::class,
        'sent_at' => 'datetime',
        'accepted_at' => 'datetime',
    ];

    public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function acceptedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function booted(): void
    {
        static::creating(function ($invitation) {
            if (empty($invitation->token)) {
                $invitation->token = Str::random(40);
            }
        });
    }
}
