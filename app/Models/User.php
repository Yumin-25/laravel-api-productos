<?php

namespace App\Models;

// Importaciones que Laravel trae por defecto
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// ★ IMPORTANTE: Importamos el trait de Sanctum
// Un 'trait' es como un paquete de habilidades extra que le damos al modelo
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    // Usamos tres traits:
    // - HasApiTokens: le da al usuario la capacidad de crear/revocar tokens (Sanctum)
    // - HasFactory: permite crear usuarios de prueba fácilmente
    // - Notifiable: permite enviar notificaciones (emails, etc.)
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Los campos que se pueden asignar masivamente (formularios, JSON, etc.)
     * Si no los listamos aquí, Laravel lanzará un error de seguridad
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Los campos que se OCULTAN al devolver el usuario como JSON
     * ¡Nunca queremos enviar la contraseña en la respuesta!
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Transformaciones automáticas de tipos
     * Esto convierte el campo 'password' automáticamente usando Hash
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }
}
