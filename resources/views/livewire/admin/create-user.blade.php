<div>
    <x-danger-button wire:click="$set('open', true)">
        Crear un nuevo usuario
    </x-danger-button>


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
