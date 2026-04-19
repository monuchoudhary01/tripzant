<?php

namespace App\Proxy\Flight;

interface FlightProvider
{
    /**
     * Search for flights and return a standardized array
     */
    public function search(array $params): array;

    /**
     * Get provider name
     */
    public function getName(): string;
    
    /**
     * Check if this provider supports booking
     */
    public function supportsBooking(): bool;
}
