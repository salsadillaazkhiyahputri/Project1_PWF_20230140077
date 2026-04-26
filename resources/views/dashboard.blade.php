<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="text-lg font-semibold mb-4">Dashboard</p>

                    
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-lg
                        {{ auth()->user()->role === 'admin'
                            ? 'bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300'
                            : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}
                        text-sm font-medium">
                        Role: <span class="font-bold capitalize">{{ ucfirst(auth()->user()->role) }}</span>
                    </div>
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
