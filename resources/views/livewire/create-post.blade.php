<div>
    

    <x-danger-button wire:click="$set('open', true)">
        Crear un nuevo post
    </x-danger-button>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            Crear nuevo post
        </x-slot>

        <x-slot name="content">
            <div wire:loading wire:target="image" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Imagen cargando</strong>
                <span class="block sm:inline">Espere un momento....</span>
            </div>

            @if($image)
                <img class="mb-4" src="{{ $image->temporaryUrl() }}">
            @endif

            <div class="mb-4">
                <x-label for="title" value="Título del post" />
                <x-input id="title" type="text" class="w-full" wire:model.defer="title" />
                <x-input-error for="title" />
            </div>

            <div class="mb-4" wire:ignore>
                <x-label for="content" value="Contenido del post" />
                <textarea id="editor" wire:model.defer="content" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="6"></textarea>
                <x-input-error for="content" />
            </div>

            <div>
                <input type="file" wire:model="image" id="{{ $identificador }}">
                <x-input-error for="image" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('open', false)">
                Cancelar
            </x-secondary-button>
            <x-danger-button wire:click="save" wire:loading.attr="disabled" wire:target="save, image" class="disabled:opacity-25">
                Crear Post
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>

    @push('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .then( editor => {
                editor.model.document.on('change:data', () => {
                    @this.set('content', editor.getData());
                });

                Livewire.on('resetCHEditor', () => {
                    editor.setData('');
                });
            })
            .catch( error => {
                console.error( error );
            });
    </script>
    @endpush
</div>
