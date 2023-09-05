<?php

namespace App\Repositories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class HotelRepository
{
    public function getFiltered(Request $request): Collection
    {
        return Hotel::query()
            ->when($request->adults, fn($query) => $query->when('adults', $request->adults))
            ->when($request->nights, fn($query) => $query->when('nights', $request->nights))
            ->get()
        ;
    }
}
