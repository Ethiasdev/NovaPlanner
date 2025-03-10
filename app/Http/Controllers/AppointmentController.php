<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\AppointmentConfirmation;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    /**
     * Show the appointment booking form
     */
    public function create()
    {
        // Generate available time slots (9 AM to 5 PM, hourly)
        $availableSlots = [];
        for ($hour = 9; $hour <= 17; $hour++) {
            $time = sprintf('%02d:00', $hour);
            $availableSlots[] = $time;
        }
        
        return view('appointments.create', [
            'availableSlots' => $availableSlots,
            'defaultDate' => Carbon::tomorrow()->format('Y-m-d')
        ]);
    }
    
    /**
     * Get available time slots for a specific date
     */
    public function getAvailableSlots(Request $request)
    {
        $date = $request->input('date');
        
        // Validate date
        if (!$date || !Carbon::createFromFormat('Y-m-d', $date)) {
            return response()->json(['error' => 'Invalid date format', 'available_slots' => []], 400);
        }
        
        Log::info("Getting available slots for date: $date");
        
        // Generate all time slots (9 AM to 5 PM, hourly)
        $allSlots = [];
        for ($hour = 9; $hour <= 17; $hour++) {
            $allSlots[] = sprintf('%02d:00', $hour);
        }
        
        // Find already booked slots (alleen bevestigde en verplaatste afspraken blokkeren tijdslots)
        $bookedSlots = Appointment::whereDate('date', $date)
            ->whereIn('status', ['bevestigd', 'verplaatst'])
            ->pluck('time')
            ->map(function ($time) {
                return Carbon::parse($time)->format('H:i');
            })
            ->toArray();
        
        Log::info("Booked slots: " . implode(', ', $bookedSlots));
        
        // Filter out booked slots
        $availableSlots = array_diff($allSlots, $bookedSlots);
        
        Log::info("Available slots: " . implode(', ', $availableSlots));
        
        return response()->json(['available_slots' => array_values($availableSlots)]);
    }
    
    /**
     * Store a new appointment
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        
        // Check if there's already a confirmed appointment at this date and time
        $existingAppointment = Appointment::where('date', $validated['date'])
            ->where('time', $validated['time'])
            ->whereIn('status', ['bevestigd', 'verplaatst'])
            ->exists();
        
        if ($existingAppointment) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['time' => 'Dit tijdslot is al geboekt. Kies een ander tijdstip.']);
        }
        
        // Create the appointment
        $appointment = Appointment::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'date' => $validated['date'],
            'time' => $validated['time'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'nieuw',
        ]);
        
        // Send confirmation email
        try {
            Mail::to($appointment->email)->send(new AppointmentConfirmation($appointment));
            
            // Update the appointment to mark confirmation as sent
            $appointment->update([
                'confirmation_sent_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Log the error but don't prevent the user from proceeding
            \Log::error('Failed to send appointment confirmation email: ' . $e->getMessage());
        }
        
        // Redirect to confirmation page
        return redirect()->route('appointments.confirmation', $appointment)
            ->with('success', 'Uw afspraak is succesvol ingepland! Een bevestiging is verzonden naar uw e-mailadres.');
    }
    
    /**
     * Show the confirmation page
     */
    public function confirmation(Appointment $appointment)
    {
        return view('appointments.confirmation', ['appointment' => $appointment]);
    }
    
    /**
     * Send a test email (for development environment only)
     */
    public function sendTestEmail()
    {
        if (!app()->environment('local', 'development')) {
            abort(404);
        }
        
        // Create a dummy appointment for testing
        $appointment = new Appointment([
            'name' => 'Test Gebruiker',
            'email' => 'test@example.com',
            'date' => now()->addDays(2),
            'time' => '14:00',
            'notes' => 'Dit is een test afspraak',
            'status' => 'nieuw',
        ]);
        
        // Send test email
        Mail::to('test@example.com')->send(new AppointmentConfirmation($appointment));
        
        return 'Test email verzonden!';
    }
}
