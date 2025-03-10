@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                <p class="mt-2 text-gray-600">Welkom terug! Hier is een overzicht van je afspraken.</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="text-right">
                    <p class="text-sm text-gray-500">Vandaag</p>
                    <p class="text-lg font-semibold text-gray-900">{{ date('d M Y') }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Status Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <!-- Total Appointments -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 overflow-hidden shadow-lg rounded-xl border border-blue-200">
            <div class="px-6 py-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <dt class="text-sm font-medium text-blue-600 truncate">
                            Totaal afspraken
                        </dt>
                        <dd class="mt-1 text-2xl font-bold text-blue-900">
                            {{ $totalCount }}
                        </dd>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- New Appointments -->
        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 overflow-hidden shadow-lg rounded-xl border border-indigo-200">
            <div class="px-6 py-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <dt class="text-sm font-medium text-indigo-600 truncate">
                            Nieuw
                        </dt>
                        <dd class="mt-1 text-2xl font-bold text-indigo-900">
                            {{ $newCount }}
                        </dd>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Confirmed Appointments -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 overflow-hidden shadow-lg rounded-xl border border-green-200">
            <div class="px-6 py-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <dt class="text-sm font-medium text-green-600 truncate">
                            Bevestigd
                        </dt>
                        <dd class="mt-1 text-2xl font-bold text-green-900">
                            {{ $confirmedCount }}
                        </dd>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Moved Appointments -->
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 overflow-hidden shadow-lg rounded-xl border border-yellow-200">
            <div class="px-6 py-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.707 3.293a1 1 0 010 1.414L5.414 7H11a7 7 0 017 7v2a1 1 0 11-2 0v-2a5 5 0 00-5-5H5.414l2.293 2.293a1 1 0 11-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <dt class="text-sm font-medium text-yellow-600 truncate">
                            Verplaatst
                        </dt>
                        <dd class="mt-1 text-2xl font-bold text-yellow-900">
                            {{ $movedCount }}
                        </dd>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Canceled Appointments -->
        <div class="bg-gradient-to-br from-red-50 to-red-100 overflow-hidden shadow-lg rounded-xl border border-red-200">
            <div class="px-6 py-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <dt class="text-sm font-medium text-red-600 truncate">
                            Geannuleerd
                        </dt>
                        <dd class="mt-1 text-2xl font-bold text-red-900">
                            {{ $canceledCount }}
                        </dd>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Today's Appointments -->
    <div class="bg-white shadow-xl overflow-hidden rounded-xl border border-gray-200 mb-8">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">
                        Afspraken vandaag
                    </h2>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    {{ $todayAppointments->count() }} afspraken
                </span>
            </div>
        </div>
        
        @if($todayAppointments->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Tijd
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Naam
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Acties
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($todayAppointments as $appointment)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-blue-400 rounded-full mr-3"></div>
                                        <span class="text-sm font-medium text-gray-900">{{ $appointment->time->format('H:i') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $appointment->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $appointment->getStatusBadgeClass() }}">
                                        {{ $appointment->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.appointments.show', $appointment) }}" 
                                           class="inline-flex items-center px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium rounded-md transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Bekijken
                                        </a>
                                        <a href="{{ route('admin.appointments.edit', $appointment) }}" 
                                           class="inline-flex items-center px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 text-xs font-medium rounded-md transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                            </svg>
                                            Bewerken
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <div class="w-12 h-12 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <p class="text-gray-500 text-sm">Geen afspraken voor vandaag.</p>
                <p class="text-gray-400 text-xs mt-1">Geniet van je vrije dag!</p>
            </div>
        @endif
    </div>
    
    <!-- Quick Links -->
    <div class="bg-white shadow-xl overflow-hidden rounded-xl border border-gray-200">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-900">
                    Snelle acties
                </h2>
            </div>
        </div>
        <div class="px-6 py-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <a href="{{ route('admin.appointments.index') }}" 
                   class="group flex items-center p-4 bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-lg border border-blue-200 transition-all duration-200 transform hover:scale-105">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center group-hover:bg-blue-600 transition-colors duration-200">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-blue-900">Alle afspraken</p>
                        <p class="text-xs text-blue-600">Bekijk en beheer alle afspraken</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Notification Container -->
    <div id="notification-container" class="fixed top-32 right-4 z-50 space-y-2"></div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Audio setup
    let audioUnlocked = false;
    let audioElement = null;
    
    // Initialize audio element
    function initAudio() {
        if (!audioElement) {
            audioElement = new Audio('{{ asset("sounds/notification.mp3") }}');
            audioElement.volume = 0.4;
            audioElement.preload = 'auto';
        }
    }
    
    // Unlock audio on first user interaction
    function unlockAudio() {
        if (!audioUnlocked && audioElement) {
            audioElement.play().then(() => {
                audioElement.pause();
                audioElement.currentTime = 0;
                audioUnlocked = true;
                console.log('🔓 Audio ontgrendeld');
            }).catch(() => {
                // Still blocked, will try again on next interaction
            });
        }
    }
    
    // Add click listener to unlock audio
    document.addEventListener('click', unlockAudio, { once: false });
    document.addEventListener('keydown', unlockAudio, { once: false });
    
    // Initialize audio immediately
    initAudio();
    
    // Start checking from 30 seconds ago to catch any recent appointments
    let lastCheckTime = new Date(Date.now() - 30000).toISOString();
    let isPolling = true;
    let pollingInterval;
    
    // Check for new appointments every 10 seconds
    function checkForNewAppointments() {
        if (!isPolling) return;
        
        fetch(`{{ route('admin.check-new-appointments') }}?last_check=${encodeURIComponent(lastCheckTime)}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    console.error('API returned error:', data.error);
                    return;
                }
                
                if (data.new_appointments && data.new_appointments.length > 0) {
                    // Show notifications for new appointments
                    data.new_appointments.forEach(appointment => {
                        showNotification(appointment);
                    });
                    
                    // Update the dashboard counts
                    updateDashboardCounts();
                }
                
                // Update last check time
                if (data.current_time) {
                    lastCheckTime = data.current_time;
                }
            })
            .catch(error => {
                console.error('Error checking for new appointments:', error);
            });
    }
    
    // Play notification sound function
    function playNotificationSound() {
        if (audioElement) {
            try {
                // Reset to beginning
                audioElement.currentTime = 0;
                
                const playPromise = audioElement.play();
                if (playPromise !== undefined) {
                    playPromise
                        .then(() => {
                            console.log('🔊 Notificatie geluid afgespeeld');
                        })
                        .catch(error => {
                            console.log('🔔 NIEUWE AFSPRAAK ONTVANGEN! (Klik ergens op de pagina om geluid in te schakelen)');
                        });
                }
            } catch (error) {
                console.log('🔔 NIEUWE AFSPRAAK ONTVANGEN!');
            }
        } else {
            console.log('🔔 NIEUWE AFSPRAAK ONTVANGEN!');
        }
    }
    
    // Show notification function
    function showNotification(appointment) {
        const notificationContainer = document.getElementById('notification-container');
        
        // Play notification sound
        playNotificationSound();
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'bg-white rounded-lg shadow-xl border border-gray-200 p-4 max-w-sm transform translate-x-full opacity-0 transition-all duration-300 ease-in-out';
        
        notification.innerHTML = `
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3 flex-1">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold text-gray-900">Nieuwe Afspraak!</p>
                        <button onclick="removeNotification(this)" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">
                        <strong>${appointment.name}</strong><br>
                        ${appointment.date} om ${appointment.time}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">
                        ${appointment.created_at_human}
                    </p>
                    <div class="mt-2">
                        <a href="{{ route('admin.appointments.index') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                            Bekijk alle afspraken →
                        </a>
                    </div>
                </div>
            </div>
        `;
        
        // Add to container
        notificationContainer.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full', 'opacity-0');
            notification.classList.add('translate-x-0', 'opacity-100');
        }, 100);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            removeNotification(notification.querySelector('button'));
        }, 5000);
    }
    
    // Remove notification function
    window.removeNotification = function(button) {
        const notification = button.closest('.bg-white');
        if (notification) {
            notification.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }
    };
    
    // Update dashboard counts (optional enhancement)
    function updateDashboardCounts() {
        // You could fetch fresh counts here and update the dashboard cards
        // For now, we'll just reload the page to get fresh data
        // window.location.reload();
    }
    
    // Update dashboard counts (optional enhancement)
    function updateDashboardCounts() {
        // Could refresh specific dashboard elements here
        // For now, we keep it simple
    }
    
    // Start polling when page loads
    checkForNewAppointments();
    pollingInterval = setInterval(checkForNewAppointments, 10000); // Check every 10 seconds
    
    // Handle page visibility changes
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            isPolling = false;
        } else {
            isPolling = true;
        }
    });
});
</script>
@endpush 