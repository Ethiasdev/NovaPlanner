@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
                <div class="px-6 py-6 bg-gradient-to-r from-indigo-600 to-indigo-700">
                    <h1 class="text-2xl font-bold text-white">Afspraak maken</h1>
                    <p class="mt-2 text-indigo-100">Vul het formulier in om een afspraak te plannen</p>
                </div>
                
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 m-6 rounded-r-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">
                                    <strong>Oeps! Er zijn enkele problemen met uw invoer:</strong>
                                </p>
                                <ul class="mt-2 text-sm text-red-700 list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                
                <form action="{{ route('appointments.store') }}" method="POST" class="px-6 py-8" x-data="appointmentForm">
                    @csrf
                    <div class="grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-6">
                        <!-- Name -->
                        <div class="sm:col-span-3">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Naam <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('name') border-red-300 @enderror" 
                                   placeholder="Uw volledige naam" required>
                        </div>

                        <!-- Email -->
                        <div class="sm:col-span-3">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                E-mailadres <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" 
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('email') border-red-300 @enderror" 
                                   placeholder="uw.email@voorbeeld.nl" required>
                        </div>

                        <!-- Phone -->
                        <div class="sm:col-span-3">
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Telefoonnummer (optioneel)
                            </label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" 
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('phone') border-red-300 @enderror" 
                                   placeholder="06-12345678">
                            <p class="mt-2 text-sm text-gray-500">
                                <svg class="inline w-4 h-4 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                </svg>
                                Voor telefonisch contact indien nodig
                            </p>
                        </div>

                        <!-- Date -->
                        <div class="sm:col-span-3">
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                                Datum <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="date" id="date" value="{{ old('date', $defaultDate) }}" 
                                   min="{{ date('Y-m-d') }}" 
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('date') border-red-300 @enderror" 
                                   required x-on:change="getAvailableTimeSlots()">
                        </div>

                        <!-- Time -->
                        <div class="sm:col-span-3">
                            <label for="time" class="block text-sm font-medium text-gray-700 mb-2">
                                Tijd <span class="text-red-500">*</span>
                            </label>
                            <select name="time" id="time" 
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('time') border-red-300 @enderror" 
                                    required>
                                <option value="">Selecteer een tijd</option>
                                <!-- Default static time options (these will be replaced by dynamic options if JS works) -->
                                @foreach($availableSlots as $slot)
                                    <option value="{{ $slot }}" {{ old('time') == $slot ? 'selected' : '' }}>{{ $slot }}</option>
                                @endforeach
                                <!-- Dynamic time options from Alpine.js -->
                                <template x-for="slot in dynamicTimeSlots" :key="slot">
                                    <option :value="slot" :selected="slot === '{{ old('time') }}'" x-text="slot"></option>
                                </template>
                            </select>
                            <p class="mt-2 text-sm text-gray-500" x-show="dynamicTimeSlots.length === 0 && jsEnabled">
                                <svg class="inline w-4 h-4 mr-1 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                Geen beschikbare tijdslots op deze datum. Kies een andere datum.
                            </p>
                        </div>

                        <!-- Notes -->
                        <div class="sm:col-span-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Opmerkingen (optioneel)
                            </label>
                            <textarea id="notes" name="notes" rows="4" 
                                      class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('notes') border-red-300 @enderror" 
                                      placeholder="Heeft u specifieke wensen of opmerkingen? Laat het ons weten...">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <button type="submit" 
                                class="w-full inline-flex justify-center items-center py-3 px-6 border border-transparent shadow-lg text-sm font-medium rounded-lg text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            Afspraak maken
                        </button>
                        <p class="mt-3 text-xs text-center text-gray-500">
                            Door op "Afspraak maken" te klikken, gaat u akkoord met onze voorwaarden.
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('appointmentForm', () => ({
            dynamicTimeSlots: [],
            jsEnabled: true,
            
            init() {
                console.log("Alpine.js initialized!");
                
                // Hide the default time slots once JS is running
                const timeSelect = document.getElementById('time');
                if (timeSelect) {
                    // Remove all static options except the first one
                    while (timeSelect.options.length > 1) {
                        timeSelect.remove(1);
                    }
                }
                
                // Load available time slots for the default date when page loads
                this.getAvailableTimeSlots();
            },
            
            getAvailableTimeSlots() {
                const date = document.getElementById('date').value;
                
                if (!date) {
                    return;
                }
                
                console.log("Fetching available slots for date:", date);
                
                fetch(`{{ route('appointments.available-slots') }}?date=${date}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log("Available slots:", data.available_slots);
                        this.dynamicTimeSlots = data.available_slots;
                        
                        // If we received the data but there are no slots, show a message
                        if (data.available_slots.length === 0) {
                            console.log("No available slots for this date");
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching available time slots:', error);
                    });
            }
        }));
    });
</script>
@endpush 