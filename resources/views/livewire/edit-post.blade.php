<div>
    <a href="#" wire:click="$set('open', true)"
        class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-green-600">
        <span class="h-1.5 w-1.5 rounded-full bg-blue-600"> </span>
        Edit
    </a>

    <x-dialog-modal wire:model="open">
        <x-slot name='title'>
            Editar el post {{ $post->title }}
        </x-slot>

        <x-slot name='content'>

            <div wire:loading wire:target="image" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Imagen cargando</strong>
                <span class="block sm:inline">Espere un momento....</span>
              </div>

            @if($image)
                <img class="mb-4" src="{{ $image->temporaryUrl() }}">
                    
                @else
                    <img src="{{ Storage::url($post->image) }}" alt="">
            @endif
            <div>
                <x-label value="Título del post" />
                <x-input wire:model="post.title" type="text" class="w-full" />
            </div>

            <div>
                <x-label value="Contenido del post" />
                <textarea wire:model="post.content"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="6">
        </textarea>

            </div>
            <div>
                <input type="file" wire:model="image" id="{{ $identificador }}">
                <x-input-error for="image"/>

            </div> 
        </x-slot>

        <x-slot name='footer'>
            <x-secondary-button wire:click="save" wire:loading.attr="disabled" class="diabled:capacity-25" >
                Actuaizar
            </x-secondary-button>
            <x-danger-button wire:click="$set('open', false)">
                Cancelar
            </x-danger-button>
        </x-slot>

    </x-dialog-modal>
</div>
