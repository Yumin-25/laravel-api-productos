<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

// ====================================================================
// RUTAS PÚBLICAS (no requieren token)
// Cualquier persona puede acceder a estos endpoints
// Analogía: son las puertas externas del edificio, abiertas para todos
// ====================================================================

// Registro de nuevo usuario
// Recibe: name, email, password, password_confirmation
Route::post('/register', [AuthController::class, 'register']);

// Inicio de sesión
// Recibe: email, password
// Devuelve: token de acceso
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:login');

// Health check (verifica que la API esté activa)
Route::get('/health', function () {
    return response()->json([
        'status'  => 'OK',
        'message' => 'API funcionando correctamente',
        'version' => '2.0 - Con autenticación',
    ]);
});

// ====================================================================
// RUTAS PROTEGIDAS (requieren token válido)
// El middleware 'auth:sanctum' es el portero que revisa el token.
// Si el token no existe o es inválido, devuelve error 401 Unauthorized.
// Analogía: son los pisos del edificio que requieren tarjeta de acceso
// ====================================================================

Route::middleware('auth:sanctum')->group(function () {

    // --- Rutas de autenticación que sí requieren estar logueado ---

    // Cerrar sesión (revoca el token actual)
    Route::post('/logout', [AuthController::class, 'logout']);

    // Obtener datos del usuario autenticado
    Route::get('/me', [AuthController::class, 'me']);

    // --- Rutas del CRUD de Productos (ahora protegidas) ---
    // Todas estas rutas requieren que el cliente envíe un token válido.
    // Sin token, devuelve 401 Unauthorized automáticamente.
    //
    // GET    /api/productos          -> index()   (listar todos)
    // POST   /api/productos          -> store()   (crear nuevo)
    // GET    /api/productos/{id}     -> show()    (ver uno)
    // PUT    /api/productos/{id}     -> update()  (actualizar)
    // DELETE /api/productos/{id}     -> destroy() (eliminar)
    Route::apiResource('productos', ProductoController::class);

});
