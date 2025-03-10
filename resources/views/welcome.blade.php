<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'NovaPlanner') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="antialiased">
        <div class="min-h-screen bg-gray-100 flex flex-col justify-center items-center">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-blue-600 mb-4">NovaPlanner</h1>
                <p class="text-xl text-gray-600">Uw online afspraken tool</p>
            </div>
            
            <div class="max-w-md w-full bg-white shadow-lg rounded-lg p-8 mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Welkom bij NovaPlanner</h2>
                <p class="text-gray-600 mb-6">
                    Plan snel en eenvoudig een afspraak met behulp van ons online boekingssysteem.
                </p>
                
                <div class="flex justify-center">
                    <a href="{{ route('appointments.create') }}" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Maak een afspraak
                    </a>
                </div>
            </div>
            
            <div class="text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} NovaPlanner. Alle rechten voorbehouden.
            </div>
        </div>
    </body>
</html>
