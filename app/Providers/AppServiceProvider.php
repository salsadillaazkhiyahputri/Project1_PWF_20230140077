<?php

namespace App\Providers;

use App\Models\User; // Ditambahkan untuk mengenali Model User
use Illuminate\Support\Facades\Gate; // Ditambahkan untuk menggunakan fitur Gate
use Illuminate\Support\Str;
use Dedoc\Scramble\Scramble;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
 

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
   // --- KONFIGURASI SCRAMBLE ---//
    Scramble::configure()
    ->routes(function (Route $route) {
        return Str::startsWith($route->uri, 'api/');
    })
    -> withDocumentTransformers(function (OpenApi $openApi) {
        $openApi->secure(
            SecurityScheme::http('bearer')
        );
    });

    Gate::define('viewApiDocs', function () {
    return true;
    }); // Mengizinkan akses ke dokumentasi API
 
    // Gate untuk menyembunyikan menu Product secara umum
    Gate::define('manage-product', function (User $user) {
        return $user->role === 'admin';
    });

    // Gate khusus untuk fitur Export (Instruksi Kelas B)
    Gate::define('export-product', function (User $user) {
        return $user->role === 'admin';
    });

    // Gate untuk Category – hanya Admin
    Gate::define('manage-category', function (User $user) {
        return $user->role === 'admin';
    });


}
}