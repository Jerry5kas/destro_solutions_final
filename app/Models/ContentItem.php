<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Support\Money;
use App\Support\Translatable;

class ContentItem extends Model
{
    use Translatable;

    /**
     * Fields that should be translatable.
     */
    protected $translatable = [
        'title',
        'description',
        'prerequisites',
        'instructor_name',
        'instructor_bio',
        'certification_details',
    ];

    protected $fillable = [
        'type',
        'title',
        'slug',
        'description',
        'category_id',
        'date',
        'objective_list',
        'image',
        'status',
        'order',
        'price',
        'currency',
        'currency_code',
        'duration_days',
        'duration_hours',
        'session_count',
        'session_length_minutes',
        'max_students',
        'start_date',
        'end_date',
        'enrollment_deadline',
        'delivery_mode',
        'level',
        'language',
        'prerequisites',
        'instructor_name',
        'instructor_bio',
        'outcomes',
        'materials_provided',
        'certification_available',
        'certification_details',
        'is_enrollable',
        'editor_content', // For blog custom editor content
    ];

    protected $appends = [
        'formatted_price',
    ];

    protected $casts = [
        'date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'enrollment_deadline' => 'date',
        'objective_list' => 'array',
        'outcomes' => 'array',
        'materials_provided' => 'array',
        'price' => 'decimal:2',
        'is_enrollable' => 'boolean',
        'certification_available' => 'boolean',
        'editor_content' => 'array', // For blog custom editor content (JSON)
    ];

    public function currencyModel()
    {
        return $this->belongsTo(Currency::class, 'currency_code', 'code');
    }

    public function resolvedCurrencyCode(): string
    {
        return strtoupper($this->currency_code ?? $this->currency ?? Money::defaultCode());
    }

    public function resolvedCurrency(): Currency
    {
        return Money::currency($this->resolvedCurrencyCode());
    }

    public function getFormattedPriceAttribute(): ?string
    {
        if ($this->price === null) {
            return null;
        }

        return Money::format($this->price, $this->resolvedCurrencyCode());
    }

    public function getCurrencySymbolAttribute(): string
    {
        $currency = $this->resolvedCurrency();

        return $currency->symbol ?? $currency->code;
    }

    public function getCurrencyDecimalsAttribute(): int
    {
        $currency = $this->resolvedCurrency();

        return $currency->decimals ?? 2;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            if (empty($item->slug)) {
                $item->slug = Str::slug($item->title);
            }
            $item->syncCurrencyCodes();
        });

        static::updating(function ($item) {
            if ($item->isDirty('title') && empty($item->slug)) {
                $item->slug = Str::slug($item->title);
            }
            $item->syncCurrencyCodes();
        });
    }

    protected function syncCurrencyCodes(): void
    {
        if (empty($this->currency_code) && !empty($this->currency)) {
            $this->currency_code = strtoupper($this->currency);
        }

        if (empty($this->currency) && !empty($this->currency_code)) {
            $this->currency = strtoupper($this->currency_code);
        }
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all enrollments for this training.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'training_id');
    }

    /**
     * Check if training is enrollable.
     */
    public function isEnrollable(): bool
    {
        return $this->is_enrollable && 
               $this->type === 'training' &&
               $this->status === 'active';
    }

    /**
     * Check if training has available spots.
     */
    public function hasAvailableSpots(): bool
    {
        if (!$this->max_students) {
            return true; // No limit
        }
        
        $currentEnrollments = $this->enrollments()
            ->where('status', 'paid')
            ->count();
            
        return $currentEnrollments < $this->max_students;
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default.png');
    }
}
