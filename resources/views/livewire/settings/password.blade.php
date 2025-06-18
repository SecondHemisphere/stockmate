<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Actualizar contraseña')" :subheading="__('Asegúrate de usar una contraseña larga y segura para proteger tu cuenta.')">
        <form wire:submit="updatePassword" class="mt-6 space-y-6">
            {{-- Contraseña actual --}}
            <flux:input wire:model="current_password" :label="__('Contraseña actual')" type="password" required
                autocomplete="current-password" />

            {{-- Nueva contraseña --}}
            <flux:input wire:model="password" :label="__('Nueva contraseña')" type="password" required
                autocomplete="new-password" />

            {{-- Confirmar nueva contraseña --}}
            <flux:input wire:model="password_confirmation" :label="__('Confirmar nueva contraseña')" type="password"
                required autocomplete="new-password" />

            {{-- Botón y mensaje --}}
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">
                        {{ __('Guardar') }}
                    </flux:button>
                </div>

                <x-action-message class="me-3" on="password-updated">
                    {{ __('Guardado.') }}
                </x-action-message>
            </div>
        </form>
    </x-settings.layout>
</section>
