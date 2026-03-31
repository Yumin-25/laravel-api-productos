<?php
namespace App\Providers;
 
// ★ NUEVO: Importamos RateLimiter para definir reglas de límite de peticiones
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
 
class AppServiceProvider extends ServiceProvider
{
    // ★ NUEVO: El método boot() se ejecuta al iniciar la aplicación
    // Es el lugar ideal para registrar los limitadores de peticiones
    public function boot(): void
    {
        // ★ NUEVO: RateLimiter::for() registra un limitador con nombre 'login'.
        // Ese nombre ('login') se usará en routes/api.php para identificarlo.
        // Limit::perMinute(5) = máximo 5 intentos por minuto desde la misma IP+email.
        // ->by() crea una clave única por email + IP para rastrear cada combinación.
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(3)->by($request->input('email').$request->ip());
        });
    }
}
