<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Hotel;
use App\Repositories\HotelRepository;
use App\Services\BookingService;
use App\Services\SurchargeService;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index(
        Request $request,
        BookingService $bookingService,
        SurchargeService $surchargeService,
        HotelRepository $hotelRepository
    ) {
        $certificate = Certificate::find(1);

        // $hotels = Hotel::all();
        // $hotels = Hotel::where('adults', $request->adults);
        // $hotels = Hotel::query()
        //     ->when($request->adults, fn($query) => $query->when('adults', $request->adults))
        //     ->when($request->nights, fn($query) => $query->when('nights', $request->nights))
        // ;
        $hotels = $hotelRepository->getFiltered($request);

        $hotelPrices = $bookingService->getPrices();

        foreach ($hotels as &$hotel) {
            $hotel->surcharge = [
                'labels' => $surchargeService->getCalculatedSurcharges($request, $certificate->adults, $certificate->nights),
                'amount' => $surchargeService->getAmount($certificate->price, $hotelPrices, $hotel->id),
            ];
        }

        return response()->json([
            'status' => true,
            'data' => Hotel::all()
        ], 200);

        // $hotel->surcharge = [
        //     'surcharges' => [
        //         '2 ночи',
        //         '1 взрослый',
        //     ],
        //     'amount' => 1000,
        // ];
    }
}
