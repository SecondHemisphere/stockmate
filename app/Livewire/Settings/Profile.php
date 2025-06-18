<?php

namespace App\Livewire\Settings;

use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Profile extends Component
{
    public string $nombre = '';
    public string $correo = '';

    public function mount(): void
    {
        $usuario = Auth::user();
        $this->nombre = $usuario->nombre;
        $this->correo = $usuario->correo;
    }

    public function updateProfileInformation(): void
    {
        $usuario = Auth::user();

        $validated = $this->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'correo' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('usuarios', 'correo')->ignore($usuario->id),
            ],
        ]);

        $usuario->nombre = $validated['nombre'];
        $usuario->correo = $validated['correo'];

        $usuario->save();

        $this->dispatch('profile-updated', name: $usuario->nombre);

        redirect()->route('settings.profile');
    }

    /**
     * Este método se deja como placeholder.
     * Puedes implementar tu propio sistema de verificación si lo necesitas.
     */
    public function resendVerificationNotification(): void
    {
        Session::flash('status', 'Funcionalidad de verificación no implementada.');
    }

    public function render()
    {
        return view('livewire.settings.profile');
    }
}
