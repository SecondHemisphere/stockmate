<?php

namespace App\Livewire\Settings;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Password extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Actualiza la contraseña del usuario autenticado.
     */
    public function updatePassword(): void
    {
        $usuario = Auth::user();

        // Validaciones básicas
        $this->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Verificar contraseña actual con método personalizado
        if (! $usuario->checkPassword($this->current_password)) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw ValidationException::withMessages([
                'current_password' => __('La contraseña actual no es correcta.'),
            ]);
        }

        // Actualizar la contraseña
        $usuario->contrasena = Hash::make($this->password);
        $usuario->save();

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}
