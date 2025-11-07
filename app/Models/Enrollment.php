<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    protected $fillable = [
        'user_id',
        'training_id',
        'payment_method',
        'payment_id',
        'amount',
        'currency',
        'status',
        'enrolled_at',
        'terms_accepted',
        'terms_accepted_at',
        'subscription_id',
        'subscription_status',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'terms_accepted' => 'boolean',
        'terms_accepted_at' => 'datetime',
        'enrolled_at' => 'datetime',
    ];

    /**
     * Get the user that owns the enrollment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the training (content item) for this enrollment.
     */
    public function training(): BelongsTo
    {
        return $this->belongsTo(ContentItem::class, 'training_id');
    }

    /**
     * Get the payment associated with this enrollment.
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Check if enrollment is paid.
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    /**
     * Check if enrollment is active.
     */
    public function isActive(): bool
    {
        return $this->isPaid() && 
               ($this->subscription_status === null || $this->subscription_status === 'active');
    }
}
