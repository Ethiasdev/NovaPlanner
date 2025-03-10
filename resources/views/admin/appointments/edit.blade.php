@extends('layouts.admin')

@section('title', 'Afspraak bewerken')

@section('content')
    <div class="mb-6 pb-4 border-b border-gray-200">
        <h1 class="text-2xl font-semibold text-gray-900">Afspraak bewerken</h1>
    </div>
    
    <div class="bg-white shadow overflow-hidden rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Afspraak informatie</h2>
        </div>
        
        <div class="px-4 py-5 sm:p-6">
            @if(in_array($appointment->status, ['bevestigd', 'verplaatst']))
                <div class="mb-4 p-4 bg-blue-50 border-l-4 border-blue-400 text-blue-700">
                    <p class="text-sm">
                        <strong>Let op:</strong> Deze afspraak heeft momenteel de status '{{ $appointment->status }}' en blokkeert daardoor de tijdslot {{ $appointment->date->format('d-m-Y') }} om {{ $appointment->time->format('H:i') }}.
                    </p>
                    <p class="text-sm mt-1">
                        Als u de status wijzigt naar 'nieuw' of 'geannuleerd', of de datum/tijd wijzigt, komt het huidige tijdslot weer beschikbaar voor nieuwe afspraken.
                    </p>
                </div>
            @endif
            
            <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST" x-data="appointmentForm">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <!-- Name -->
                    <div class="sm:col-span-3">
                        <label for="name" class="block text-sm font-medium text-gray-700">Naam</label>
                        <div class="mt-1">
                            <input type="text" name="name" id="name" value="{{ old('name', $appointment->name) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('name') border-red-300 @enderror">
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="sm:col-span-3">
                        <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                        <div class="mt-1">
                            <input type="email" name="email" id="email" value="{{ old('email', $appointment->email) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('email') border-red-300 @enderror">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="sm:col-span-3">
                        <label for="phone" class="block text-sm font-medium text-gray-700">Telefoonnummer</label>
                        <div class="mt-1">
                            <input type="tel" name="phone" id="phone" value="{{ old('phone', $appointment->phone) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('phone') border-red-300 @enderror">
                        </div>
                        @error('phone')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="sm:col-span-3">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <div class="mt-1">
                            <select name="status" id="status" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('status') border-red-300 @enderror" x-model="appointmentStatus" x-on:change="updateStatusInfo()">
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ old('status', $appointment->status) === $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-1" x-show="showStatusInfo">
                            <p class="text-sm text-blue-600" x-text="statusInfoText"></p>
                        </div>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Date -->
                    <div class="sm:col-span-3">
                        <label for="date" class="block text-sm font-medium text-gray-700">Datum</label>
                        <div class="mt-1">
                            <input type="date" name="date" id="date" value="{{ old('date', $appointment->date->format('Y-m-d')) }}" 
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('date') border-red-300 @enderror"
                                x-on:change="getAvailableTimeSlots(); updateDateTimeInfo()">
                        </div>
                        @error('date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Time -->
                    <div class="sm:col-span-3">
                        <label for="time" class="block text-sm font-medium text-gray-700">Tijd</label>
                        <div class="mt-1">
                            <select name="time" id="time" 
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('time') border-red-300 @enderror"
                                x-on:change="updateDateTimeInfo()">
                                <option value="">Selecteer een tijd</option>
                                
                                <!-- Default static time options (these will be replaced by dynamic options if JS works) -->
                                @foreach($availableSlots as $slot)
                                    <option value="{{ $slot }}" {{ old('time', $appointment->time->format('H:i')) == $slot ? 'selected' : '' }}>
                                        {{ $slot }}
                                    </option>
                                @endforeach
                                
                                <!-- Dynamic time options from Alpine.js -->
                                <template x-for="slot in dynamicTimeSlots" :key="slot">
                                    <option :value="slot" :selected="slot === '{{ old('time', $appointment->time->format('H:i')) }}'" x-text="slot"></option>
                                </template>
                                
                                <!-- Always show the current time even if occupied -->
                                <template x-if="!dynamicTimeSlots.includes('{{ $appointment->time->format('H:i') }}') && currentTime !== '' && jsEnabled">
                                    <option value="{{ $appointment->time->format('H:i') }}" selected>
                                        {{ $appointment->time->format('H:i') }} (huidige tijd)
                                    </option>
                                </template>
                            </select>
                        </div>
                        <div class="mt-1" x-show="showDateTimeInfo">
                            <p class="text-sm text-blue-600" x-text="dateTimeInfoText"></p>
                        </div>
                        <p class="mt-1 text-sm text-gray-500" x-show="dynamicTimeSlots.length === 0 && !isCurrentTimeShown && jsEnabled">
                            Geen beschikbare tijdslots op deze datum. Kies een andere datum.
                        </p>
                        @error('time')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="sm:col-span-6">
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notities</label>
                        <div class="mt-1">
                            <textarea name="notes" id="notes" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('notes') border-red-300 @enderror">{{ old('notes', $appointment->notes) }}</textarea>
                        </div>
                        @error('notes')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('admin.appointments.show', $appointment) }}" class="py-2 px-4 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded border border-gray-300">
                        Annuleren
                    </a>
                    <button type="submit" class="py-2 px-4 bg-blue-100 hover:bg-blue-200 text-blue-800 rounded border border-blue-300">
                        Opslaan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('appointmentForm', () => ({
            dynamicTimeSlots: [],
            appointmentStatus: '{{ old('status', $appointment->status) }}',
            currentTime: '{{ $appointment->time->format('H:i') }}',
            originalDate: '{{ $appointment->date->format('Y-m-d') }}',
            originalTime: '{{ $appointment->time->format('H:i') }}',
            originalStatus: '{{ $appointment->status }}',
            showStatusInfo: false,
            statusInfoText: '',
            showDateTimeInfo: false,
            dateTimeInfoText: '',
            isCurrentTimeShown: false,
            jsEnabled: true,
            
            init() {
                console.log("Admin edit form: Alpine.js initialized!");
                
                // Hide the default time slots once JS is running
                const timeSelect = document.getElementById('time');
                if (timeSelect) {
                    // Remove all static options except the first one
                    while (timeSelect.options.length > 1) {
                        timeSelect.remove(1);
                    }
                }
                
                // Load available time slots for the current date when page loads
                this.getAvailableTimeSlots();
                this.updateStatusInfo();
                this.updateDateTimeInfo();
            },
            
            getAvailableTimeSlots() {
                const date = document.getElementById('date').value;
                
                if (!date) {
                    return;
                }
                
                console.log("Admin: Fetching available slots for date:", date);
                
                fetch(`{{ route('admin.appointments.available-slots') }}?date=${date}&appointment_id={{ $appointment->id }}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log("Admin: Available slots:", data.available_slots);
                        this.dynamicTimeSlots = data.available_slots;
                        this.isCurrentTimeShown = date === this.originalDate && 
                            !this.dynamicTimeSlots.includes(this.originalTime);
                            
                        // Always include current time in the select
                        if (date === this.originalDate && !this.dynamicTimeSlots.includes(this.originalTime)) {
                            console.log("Admin: Adding current time back to options:", this.originalTime);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching available time slots:', error);
                    });
            },
            
            updateStatusInfo() {
                const isConfirmingStatus = ['bevestigd', 'verplaatst'].includes(this.appointmentStatus);
                const wasConfirmedStatus = ['bevestigd', 'verplaatst'].includes(this.originalStatus);
                
                if (wasConfirmedStatus && !isConfirmingStatus) {
                    this.showStatusInfo = true;
                    this.statusInfoText = 'Als u deze wijziging opslaat, wordt de huidige tijdslot weer beschikbaar voor nieuwe afspraken.';
                } else if (!wasConfirmedStatus && isConfirmingStatus) {
                    this.showStatusInfo = true;
                    this.statusInfoText = 'Als u deze wijziging opslaat, wordt de gekozen tijdslot geblokkeerd voor nieuwe afspraken.';
                } else {
                    this.showStatusInfo = false;
                }
            },
            
            updateDateTimeInfo() {
                const date = document.getElementById('date').value;
                const time = document.getElementById('time').value;
                const isConfirmingStatus = ['bevestigd', 'verplaatst'].includes(this.appointmentStatus);
                
                if (isConfirmingStatus && (date !== this.originalDate || time !== this.originalTime) && date && time) {
                    this.showDateTimeInfo = true;
                    if (date !== this.originalDate && time !== this.originalTime) {
                        this.dateTimeInfoText = 'Bij het opslaan wordt de oorspronkelijke tijdslot vrijgegeven en de nieuwe tijdslot geblokkeerd.';
                    } else if (date !== this.originalDate) {
                        this.dateTimeInfoText = 'Bij het opslaan wordt de oorspronkelijke tijdslot vrijgegeven en de nieuwe datum geblokkeerd.';
                    } else if (time !== this.originalTime) {
                        this.dateTimeInfoText = 'Bij het opslaan wordt de oorspronkelijke tijdslot vrijgegeven en de nieuwe tijd geblokkeerd.';
                    }
                } else {
                    this.showDateTimeInfo = false;
                }
            }
        }));
    });
</script>
@endpush 