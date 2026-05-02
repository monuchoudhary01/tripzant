<?php

namespace App\Proxy\Flight;

class UnifiedFlight
{
    public $id;
    public $gds_id;
    public $airline_code;
    public $airline_name;
    public $flight_number;
    public $departure_at;
    public $arrival_at;
    public $departure_city;
    public $arrival_city;
    public $duration;
    public $stops;
    public $price;
    public $net_price;
    public $currency;
    public $cabin;
    public $baggage;
    public $baggage_unit;
    public $terminal;
    public $source; // amadeus, rapidapi, scraper
    public $is_cheapest = false;
    public $booking_class;
    public $seats_available;
    public $raw_data;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}
