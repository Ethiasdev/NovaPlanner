<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Exception;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        // Get counts for different appointment statuses
        $totalCount = Appointment::count();
        $newCount = Appointment::where('status', 'nieuw')->count();
        $confirmedCount = Appointment::where('status', 'bevestigd')->count();
        $movedCount = Appointment::where('status', 'verplaatst')->count();
        $canceledCount = Appointment::where('status', 'geannuleerd')->count();
        
        // Get today's appointments
        $todayAppointments = Appointment::whereDate('date', Carbon::today())
            ->orderBy('time')
            ->get();
        
        return view('admin.dashboard', [
            'totalCount' => $totalCount,
            'newCount' => $newCount,
            'confirmedCount' => $confirmedCount,
            'movedCount' => $movedCount,
            'canceledCount' => $canceledCount,
            'todayAppointments' => $todayAppointments
        ]);
    }
    
    /**
     * Display a listing of the appointments.
     */
    public function appointments(Request $request)
    {
        // Get filter parameters
        $dateFilter = $request->input('date');
        $statusFilter = $request->input('status');
        
        // Build query
        $query = Appointment::query()->orderBy('date', 'desc')->orderBy('time', 'asc');
        
        // Apply date filter if provided
        if ($dateFilter) {
            $query->whereDate('date', $dateFilter);
        }
        
        // Apply status filter if provided
        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }
        
        // Get appointments with pagination
        $appointments = $query->paginate(10);
        
        return view('admin.appointments.index', [
            'appointments' => $appointments,
            'dateFilter' => $dateFilter,
            'statusFilter' => $statusFilter
        ]);
    }
    
    /**
     * Display the specified appointment.
     */
    public function show(Appointment $appointment)
    {
        return view('admin.appointments.show', [
            'appointment' => $appointment
        ]);
    }
    
    /**
     * Show the form for editing the specified appointment.
     */
    public function edit(Appointment $appointment)
    {
        // Generate available time slots (9 AM to 5 PM, hourly)
        $availableSlots = [];
        for ($hour = 9; $hour <= 17; $hour++) {
            $time = sprintf('%02d:00', $hour);
            $availableSlots[] = $time;
        }
        
        return view('admin.appointments.edit', [
            'appointment' => $appointment,
            'availableSlots' => $availableSlots,
            'statuses' => ['nieuw', 'bevestigd', 'verplaatst', 'geannuleerd']
        ]);
    }
    
    /**
     * Update the specified appointment in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'date' => 'required|date',
            'time' => 'required|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:nieuw,bevestigd,verplaatst,geannuleerd',
        ]);
        
        // Save original values for comparison
        $originalStatus = $appointment->status;
        $originalDate = $appointment->date->format('Y-m-d');
        $originalTime = $appointment->time->format('H:i');
        
        // Check if date and time are available (if changing to or already in 'bevestigd' or 'verplaatst' status)
        if (in_array($validated['status'], ['bevestigd', 'verplaatst'])) {
            // Only check availability if date or time changed
            if ($originalDate != $validated['date'] || $originalTime != $validated['time']) {
                // Check if there's already an appointment at this date and time
                $existingAppointment = Appointment::where('id', '!=', $appointment->id)
                    ->where('date', $validated['date'])
                    ->where('time', $validated['time'])
                    ->whereIn('status', ['bevestigd', 'verplaatst'])
                    ->exists();
                
                if ($existingAppointment) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['time' => 'Dit tijdslot is al geboekt door een andere bevestigde afspraak. Kies een ander tijdstip.']);
                }
            }
        }
        
        // Update the appointment
        $appointment->update($validated);
        
        // Provide specific success message based on what changed
        $message = 'Afspraak is succesvol bijgewerkt.';
        
        // If status changed from confirmed/moved to something else, or date/time changed for confirmed appointment
        if ((in_array($originalStatus, ['bevestigd', 'verplaatst']) && !in_array($validated['status'], ['bevestigd', 'verplaatst'])) ||
            (in_array($originalStatus, ['bevestigd', 'verplaatst']) && ($originalDate != $validated['date'] || $originalTime != $validated['time']))) {
            $message = 'Afspraak is bijgewerkt. De oorspronkelijke tijdslot is nu weer beschikbaar.';
        }
        
        // If status changed to confirmed/moved, or date/time changed for confirmed appointment
        if ((!in_array($originalStatus, ['bevestigd', 'verplaatst']) && in_array($validated['status'], ['bevestigd', 'verplaatst'])) ||
            (in_array($validated['status'], ['bevestigd', 'verplaatst']) && ($originalDate != $validated['date'] || $originalTime != $validated['time']))) {
            $message = 'Afspraak is bijgewerkt. De nieuwe tijdslot is nu geblokkeerd voor andere afspraken.';
        }
        
        return redirect()->route('admin.appointments.show', $appointment)
            ->with('success', $message);
    }
    
    /**
     * Remove the specified appointment from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $wasBlockingSlot = in_array($appointment->status, ['bevestigd', 'verplaatst']);
        $appointment->delete();
        
        $message = 'Afspraak is succesvol verwijderd.';
        if ($wasBlockingSlot) {
            $message = 'Afspraak is verwijderd. De tijdslot is nu weer beschikbaar voor nieuwe afspraken.';
        }
        
        return redirect()->route('admin.appointments.index')
            ->with('success', $message);
    }
    
    /**
     * Get available time slots for a specific date.
     */
    public function getAvailableSlots(Request $request)
    {
        $date = $request->input('date');
        $appointmentId = $request->input('appointment_id');
        
        // Validate date
        if (!$date || !Carbon::createFromFormat('Y-m-d', $date)) {
            return response()->json(['error' => 'Invalid date format', 'available_slots' => []], 400);
        }
        
        Log::info("Admin: Getting available slots for date: $date" . ($appointmentId ? " (excluding appointment #$appointmentId)" : ""));
        
        // Generate all time slots (9 AM to 5 PM, hourly)
        $allSlots = [];
        for ($hour = 9; $hour <= 17; $hour++) {
            $allSlots[] = sprintf('%02d:00', $hour);
        }
        
        // Find already booked slots (only from confirmed and moved appointments)
        $bookedSlots = Appointment::whereDate('date', $date)
            ->whereIn('status', ['bevestigd', 'verplaatst'])
            ->when($appointmentId, function ($query, $id) {
                return $query->where('id', '!=', $id); // Exclude current appointment when editing
            })
            ->pluck('time')
            ->map(function ($time) {
                return Carbon::parse($time)->format('H:i');
            })
            ->toArray();
        
        Log::info("Admin: Booked slots: " . implode(', ', $bookedSlots));
        
        // Filter out booked slots
        $availableSlots = array_diff($allSlots, $bookedSlots);
        
        Log::info("Admin: Available slots: " . implode(', ', $availableSlots));
        
        return response()->json(['available_slots' => array_values($availableSlots)]);
    }

    /**
     * Check for new appointments since last check (for real-time notifications)
     */
    public function checkNewAppointments(Request $request)
    {
        $lastCheck = $request->input('last_check');
        
        if (!$lastCheck) {
            // If no last check time, check for appointments from the last 5 minutes
            $lastCheckTime = now()->subMinutes(5);
        } else {
            try {
                $lastCheckTime = Carbon::parse($lastCheck);
            } catch (Exception $e) {
                return response()->json(['error' => 'Invalid last_check format'], 400);
            }
        }
        
        // Get appointments created after the last check time (with a small buffer for timing issues)
        $bufferTime = $lastCheckTime->subSeconds(5); // 5 second buffer for timing discrepancies
        
        $newAppointments = Appointment::where('created_at', '>', $bufferTime)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'name' => $appointment->name,
                    'email' => $appointment->email,
                    'date' => $appointment->date->format('d-m-Y'),
                    'time' => $appointment->time->format('H:i'),
                    'created_at' => $appointment->created_at->format('H:i:s'),
                    'created_at_human' => $appointment->created_at->diffForHumans(),
                ];
            });
        
        return response()->json([
            'new_appointments' => $newAppointments,
            'count' => $newAppointments->count(),
            'current_time' => now()->toISOString()
        ]);
    }


} 