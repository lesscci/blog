<div>


    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md m-5">
        <div class="px-6 py-4 items-center">
            <x-input type="text" wire:model="search" class="flex-1 mr-4" placeholder="Escribe que quiere buscar" />
            @livewire('create-post')
        </div>

        @if ($posts->count())
            <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class=" cursor-pointer px-6 py-4 font-medium text-gray-900"
                            wire:click="order('id')">ID</th>
                        <th scope="col" class=" cursor-pointer px-6 py-4 font-medium text-gray-900"
                            wire:click="order('title')">Title</th>
                        <th scope="col" class=" cursor-pointer px-6 py-4 font-medium text-gray-900"
                            wire:click="order('content')">Content</th>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 border-t border-gray-100">

                    @foreach ($posts as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-green-600">
                                    <span class="h-1.5 w-1.5 rounded-full bg-green-600"></span>
                                    {{ $item->id }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $item->title }}</td>
                            <td class="px-6 py-4">{{ $item->content }}</td>
                            <td class="px-6 py-4">
                              
                                <a href="#" wire:click="edit({{ $item }})"
                                class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-green-600">
                                <span class="h-1.5 w-1.5 rounded-full bg-blue-600"> </span>
                                Edit
                            </a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        @else
            <div class="px-6 py-4">
                No existe ningún registro coincidente.
            </div>
        @endif

        @if($posts->hasPages())
        <div class="px-6 py-3">
            {{ $posts->links() }}
        </div>
        @endif
    </div>

    <x-dialog-modal wire:model="open_edit">
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
            <x-secondary-button wire:click="update" wire:loading.attr="disabled" class="diabled:capacity-25" >
                Actuaizar
            </x-secondary-button>
            <x-danger-button wire:click="$set('open_edit', false)">
                Cancelar
            </x-danger-button>
        </x-slot>

    </x-dialog-modal>

</div>
