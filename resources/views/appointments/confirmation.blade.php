@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-blue-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Animation Container -->
        <div class="text-center mb-8 animate-bounce">
            <div class="mx-auto h-24 w-24 flex items-center justify-center bg-gradient-to-r from-green-400 to-green-600 rounded-full shadow-lg mb-6">
                <svg class="h-12 w-12 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                🎉 Gefeliciteerd!
            </h1>
            <h2 class="text-2xl font-semibold text-gray-700 mb-2">
                Uw afspraak is succesvol bevestigd
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Bedankt voor het vertrouwen in NovaPlanner. We hebben uw afspraak ontvangen en bevestigd. U ontvangt binnenkort een bevestiging per e-mail.
            </p>
        </div>

        <!-- Appointment Details Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden mb-8">
            <div class="px-8 py-6 bg-gradient-to-r from-blue-600 to-indigo-700">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white">Uw Afspraak Details</h3>
                        <p class="text-blue-100">Alle informatie over uw geboekte afspraak</p>
                    </div>
                </div>
            </div>
            
            <div class="px-8 py-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Personal Information -->
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">Contactpersoon</h4>
                                <p class="text-xl font-semibold text-gray-900">{{ $appointment->name }}</p>
                                <p class="text-gray-600 mt-1">{{ $appointment->email }}</p>
                                @if($appointment->phone)
                                <p class="text-gray-600 mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                    </svg>
                                    {{ $appointment->phone }}
                                </p>
                                @endif
                            </div>
                        </div>

                        @if($appointment->notes)
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a2 2 0 002 2h4a2 2 0 002-2V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm2.5 3a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm2.45 4a2.5 2.5 0 10-4.9 0h4.9zM12 9a1 1 0 100 2h3a1 1 0 100-2h-3zm-1 4a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">Opmerkingen</h4>
                                <p class="text-gray-900 leading-relaxed">{{ $appointment->notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Appointment Time -->
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">Datum</h4>
                                <p class="text-xl font-semibold text-gray-900">{{ $appointment->date->format('l, d F Y') }}</p>
                                <p class="text-gray-600 mt-1">{{ $appointment->date->diffForHumans() }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">Tijd</h4>
                                <p class="text-xl font-semibold text-gray-900">{{ $appointment->time }}</p>
                                <p class="text-gray-600 mt-1">Nederlandse tijd (CET)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <div class="flex items-center justify-center">
                        <span class="inline-flex items-center px-6 py-3 rounded-full text-sm font-semibold bg-green-100 text-green-800 border border-green-200">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Status: Bevestigd & Geboekt
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mb-8">
            <div class="px-8 py-6 bg-gradient-to-r from-indigo-50 to-blue-50 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Wat gebeurt er nu?
                </h3>
            </div>
            <div class="px-8 py-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">E-mail Bevestiging</h4>
                        <p class="text-sm text-gray-600">U ontvangt binnen 5 minuten een bevestigingsmail op {{ $appointment->email }}</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">Voorbereiding</h4>
                        <p class="text-sm text-gray-600">Zorg ervoor dat u op tijd bent en eventuele benodigde documenten meeneemt</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">Wijzigingen</h4>
                        <p class="text-sm text-gray-600">Heeft u wijzigingen? Neem minimaal 24 uur van tevoren contact met ons op</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="text-center space-y-4">
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('appointments.create') }}" 
                   class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                    </svg>
                    Nieuwe Afspraak Maken
                </a>
                
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center justify-center px-8 py-4 border border-gray-300 text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L10 4.414l6.293 6.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Terug naar Dashboard
                </a>
            </div>
            
            <p class="text-sm text-gray-500 mt-6">
                Heeft u vragen over uw afspraak? Neem gerust contact met ons op via email of telefoon.
            </p>
        </div>
    </div>
</div>

<style>
@keyframes bounce {
    0%, 20%, 53%, 80%, 100% {
        transform: translate3d(0,0,0);
    }
    40%, 43% {
        transform: translate3d(0,-15px,0);
    }
    70% {
        transform: translate3d(0,-7px,0);
    }
    90% {
        transform: translate3d(0,-2px,0);
    }
}

.animate-bounce {
    animation: bounce 2s infinite;
}
</style>
@endsection 