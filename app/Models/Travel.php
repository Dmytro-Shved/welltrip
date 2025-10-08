<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function tours(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }
}
