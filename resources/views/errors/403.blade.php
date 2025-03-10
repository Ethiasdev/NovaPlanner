@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-orange-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
        <!-- Error Icon -->
        <div class="mx-auto h-24 w-24 flex items-center justify-center bg-red-100 rounded-full">
            <svg class="h-12 w-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
        </div>

        <!-- Error Message -->
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">403</h1>
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Toegang Geweigerd</h2>
            <p class="text-gray-600 mb-6">
                U heeft geen toestemming om deze pagina te bekijken. Deze pagina is alleen toegankelijk voor beheerders.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-4">
            <a href="{{ route('home') }}" 
               class="w-full inline-flex justify-center items-center py-3 px-6 border border-transparent shadow-lg text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L10 4.414l6.293 6.293a1 1 0 001.414-1.414l-7-7z"></path>
                </svg>
                Terug naar Dashboard
            </a>

            <a href="{{ url('/') }}" 
               class="w-full inline-flex justify-center items-center py-3 px-6 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                </svg>
                Terug naar Hoofdpagina
            </a>
        </div>

        <!-- Additional Info -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-8">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-sm text-yellow-800">
                    <strong>Let op:</strong> Als u denkt dat u wel toegang zou moeten hebben, neem dan contact op met de beheerder.
                </p>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="text-center text-sm text-gray-500">
            <p>Heeft u vragen? Neem contact op via email of telefoon.</p>
        </div>
    </div>
</div>
@endsection 