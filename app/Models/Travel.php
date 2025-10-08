<?php

namespace App\Models;

use App\Observers\TravelObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

#[ObservedBy(TravelObserver::class)]
class Travel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'travels';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'is_public',
        'slug',
        'name',
        'description',
        'numberOfDays',
        'numberOfNights',
    ];

    protected function numberOfDays(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => [
                'numberOfDays' => $value,
                'numberOfNights' => $value - 1,
            ],
        );
    }

    public function tours(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }
}
