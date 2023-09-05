<?php

namespace App\Services;

class SurchargeService
{
    public function getCalculatedSurcharges($req, $adultCount, $nightCount)
    {
        $nightsReq = $req->post('night') ?? 0;
        $adultsReq = $req->post('adult') ?? 0;

        // $adultLabel = $adultsReq - $adultCount;
        // $nightLabel = $nightsReq - $nightCount;

        $result = [];

        if ($adultsReq - $adultCount > 0) {
            $result['adultLabel'] = "2 adults";
        }

        if ($nightsReq - $nightCount > 0) {
            $result['nightLabel'] = "2 nights";
        }

        // return [
        //     'adultLabel' => $adultLabel,
        //     'nightLabel' => $nightCount
        // ];

        return $result;
    }

    public function getLabels(): array
    {
        return [

        ];
    }

    public function getAmount($certificatePrice, $hotelPrices, $hotelId): int
    {
        $hotelPrice = array_search($hotelId, $hotelPrices);
        $finishPrice = $hotelPrice - $certificatePrice;

        return max(0, $finishPrice);
    }
}
