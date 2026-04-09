<?php

namespace App\Providers;

use App\Models\User; // Ditambahkan untuk mengenali Model User
use Illuminate\Support\Facades\Gate; // Ditambahkan untuk menggunakan fitur Gate
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }  

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    // Gate untuk menyembunyikan menu Product secara umum
    Gate::define('manage-product', function (User $user) {
        return $user->role === 'admin';
    });

    // Gate khusus untuk fitur Export (Instruksi Kelas B)
    Gate::define('export-product', function (User $user) {
        return $user->role === 'admin';
    });
}
}