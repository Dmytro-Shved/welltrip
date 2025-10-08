<?php

namespace App\Observers;
use App\Models\Travel;
use Illuminate\Support\Str;

class TravelObserver
{
    public function creating(Travel $travel): void
    {
        $travelNames = Travel::where('name', $travel->name)->count();

        if (is_null($travel->slug) && $travelNames == 0) {
            $travel->slug = Str::slug($travel->name);
        }else{
            $travel->slug = Str::slug($travel->name . '-' . $travelNames);
        }
    }

    public function updating(Travel $travel): void
    {
        $travelNames = Travel::where('name', $travel->name)->count();

        if (! is_null($travel->slug) && $travelNames == 0) {
            $travel->slug = Str::slug($travel->name);
        }else{
            $travel->slug = Str::slug($travel->name . '-' . $travelNames);
        }
    }
}
