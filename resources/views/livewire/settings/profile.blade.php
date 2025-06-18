<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Perfil')" :subheading="__('Actualiza tu nombre y dirección de correo electrónico')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            {{-- Campo: Nombre --}}
            <flux:input wire:model="nombre" :label="__('Nombre')" type="text" required autofocus autocomplete="name" />

            {{-- Campo: Correo --}}
            <div>
                <flux:input wire:model="correo" :label="__('Correo electrónico')" type="email" required
                    autocomplete="email" />

                {{-- Opcional: Sección de verificación de email (si se implementa) --}}
                @if (session('status') === 'verification-link-sent')
                    <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                        {{ __('Se ha enviado un nuevo enlace de verificación a tu correo electrónico.') }}
                    </flux:text>
                @endif
            </div>

            {{-- Botón de guardar --}}
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">
                        {{ __('Guardar') }}
                    </flux:button>
                </div>

                {{-- Mensaje de éxito al guardar --}}
                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Guardado.') }}
                </x-action-message>
            </div>
        </form>

    </x-settings.layout>
</section>
