<div>
    <a href="#" wire:click="$set('open', true)"
        class="inline-flex items-center gap-1 bg-green-50 px-2 py-1 text-xs font-semibold text-600">
        <span class="h-1.5 w-1.5 bg-blue-600"> </span>
        Edit
    </a>

    <x-dialog-modal wire:model="open">

        <x-slot name="title">
            Editar usuario {{ $user->name }} 
        </x-slot>
        <x-slot name="content">
            <div>
                <x-label value="Nombre" />
                <x-input wire:model="user.name" type="text" class="w-full" />
            </div>
            <div>
                <x-label value="Email" />
                <x-input wire:model="user.email" type="text" class="w-full" />
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="save" wire:loading.attr="disabled" class="diabled:capacity-25" >
                Actuaizar
            </x-secondary-button>
            <x-danger-button wire:click="$set('open', false)">
                Cancelar
            </x-danger-button>
        </x-slot>

    </x-dialog-modal>

</div>
