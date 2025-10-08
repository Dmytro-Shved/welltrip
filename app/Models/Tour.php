<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tour extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'tours';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'name',
        'startingDate',
        'endingDate',
        'price',
        'travel_uuid'
    ];

    public function travels(): HasMany
    {
        return $this->hasMany(Travel::class);
    }
}
