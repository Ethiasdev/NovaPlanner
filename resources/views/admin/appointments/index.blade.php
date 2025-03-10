@extends('layouts.admin')

@section('title', 'Afspraken')

@section('content')
    <div class="mb-6 pb-4 border-b border-gray-200">
        <h1 class="text-2xl font-semibold text-gray-900">Afspraken</h1>
    </div>
    
    <!-- Filters -->
    <div class="bg-white shadow overflow-hidden rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Filter afspraken</h2>
        </div>
        
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('admin.appointments.index') }}" method="GET" class="space-y-4 sm:space-y-0 sm:flex sm:items-end sm:space-x-4">
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">Datum</label>
                    <input type="date" name="date" id="date" value="{{ $dateFilter }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Alle statussen</option>
                        <option value="nieuw" {{ $statusFilter === 'nieuw' ? 'selected' : '' }}>Nieuw</option>
                        <option value="bevestigd" {{ $statusFilter === 'bevestigd' ? 'selected' : '' }}>Bevestigd</option>
                        <option value="verplaatst" {{ $statusFilter === 'verplaatst' ? 'selected' : '' }}>Verplaatst</option>
                        <option value="geannuleerd" {{ $statusFilter === 'geannuleerd' ? 'selected' : '' }}>Geannuleerd</option>
                        <option value="pending" {{ $statusFilter === 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                
                <div class="sm:flex-grow flex flex-col sm:flex-row gap-2">
                    <button type="submit" class="py-2 px-4 bg-blue-100 hover:bg-blue-200 text-blue-800 rounded border border-blue-300">
                        Filter toepassen
                    </button>
                    
                    <a href="{{ route('admin.appointments.index') }}" class="py-2 px-4 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded border border-gray-300 text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Appointments Table -->
    <div class="bg-white shadow overflow-hidden rounded-lg">
        <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Overzicht afspraken</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Datum
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tijd
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Naam
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Telefoon
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acties
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($appointments as $appointment)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $appointment->date->format('d-m-Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $appointment->time->format('H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $appointment->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $appointment->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $appointment->phone ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $appointment->getStatusBadgeClass() }}">
                                    {{ $appointment->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex flex-wrap gap-1">
                                    <a href="{{ route('admin.appointments.show', $appointment) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-1 px-3 rounded">
                                        Bekijken
                                    </a>
                                    <a href="{{ route('admin.appointments.edit', $appointment) }}" class="bg-blue-100 hover:bg-blue-200 text-blue-800 py-1 px-3 rounded">
                                        Bewerken
                                    </a>
                                    <button type="button" class="bg-red-100 hover:bg-red-200 text-red-800 py-1 px-3 rounded"
                                            x-data
                                            x-on:click="if (confirm('Weet je zeker dat je deze afspraak wilt verwijderen?')) { 
                                                document.getElementById('delete-form-{{ $appointment->id }}').submit();
                                            }">
                                        Verwijderen
                                    </button>
                                    <form id="delete-form-{{ $appointment->id }}" action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                Geen afspraken gevonden.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $appointments->withQueryString()->links() }}
        </div>
    </div>
@endsection 