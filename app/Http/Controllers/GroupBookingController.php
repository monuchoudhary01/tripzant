<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\GroupBookingRequest;
use Illuminate\Support\Facades\Mail;

class GroupBookingController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'passengers' => 'required|integer|min:10',
            'airline' => 'sometimes|string',
            'flight_number' => 'sometimes|string',
            'departure' => 'sometimes|string',
            'arrival' => 'sometimes|string',
            'date' => 'sometimes|date',
            'class' => 'required|string',
            'remarks' => 'nullable|string',
            'onward_details' => 'nullable|string',
            'return_details' => 'nullable|string',
            'multi_city_details' => 'nullable|string',
        ]);

        $groupBooking = GroupBookingRequest::create($validatedData);

        // Send Email Notification
        try {
            $adminEmail = config('mail.from.address', 'admin@easitrip.com');
            $details = "A new group booking request has been received:\n\n" .
                       "Name: {$groupBooking->name}\n" .
                       "Email: {$groupBooking->email}\n" .
                       "Phone: {$groupBooking->phone}\n" .
                       "Passengers: {$groupBooking->passengers}\n" .
                       "Class: {$groupBooking->class}\n";

            if ($groupBooking->multi_city_details) {
                $segments = json_decode($groupBooking->multi_city_details, true);
                if (is_array($segments)) {
                    foreach ($segments as $index => $leg) {
                        $details .= "\n--- LEG " . ($index + 1) . " ---\n" .
                                   "Airline: {$leg['details']['airline']}\n" .
                                   "Flight: {$leg['details']['flight_number']}\n" .
                                   "Route: {$leg['details']['dep_city']} to {$leg['details']['arr_city']}\n" .
                                   "Time: {$leg['details']['dep_time']} - {$leg['details']['arr_time']}\n" .
                                   "Date: {$leg['details']['date']}\n";
                    }
                }
            } else {
                if ($groupBooking->onward_details) {
                    $onward = json_decode($groupBooking->onward_details, true);
                    $details .= "\n--- ONWARD JOURNEY ---\n" .
                               "Airline: {$onward['airline']}\n" .
                               "Flight: {$onward['flight_number']}\n" .
                               "Route: {$onward['dep_city']} to {$onward['arr_city']}\n" .
                               "Time: {$onward['dep_time']} - {$onward['arr_time']}\n" .
                               "Date: {$onward['date']}\n";
                }

                if ($groupBooking->return_details) {
                    $return = json_decode($groupBooking->return_details, true);
                    $details .= "\n--- RETURN JOURNEY ---\n" .
                               "Airline: {$return['airline']}\n" .
                               "Flight: {$return['flight_number']}\n" .
                               "Route: {$return['dep_city']} to {$return['arr_city']}\n" .
                               "Time: {$return['dep_time']} - {$return['arr_time']}\n" .
                               "Date: {$return['date']}\n";
                }
            }

            if ($groupBooking->remarks) {
                $details .= "\nRemarks: {$groupBooking->remarks}\n";
            }

            Mail::raw($details, function ($message) use ($adminEmail) {
                $message->to($adminEmail)
                        ->subject('New Group Booking Request Received');
            });
        } catch (\Exception $e) {
            \Log::error("Failed to send group booking notification: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Your group booking request has been submitted successfully.'
        ]);
    }
}
