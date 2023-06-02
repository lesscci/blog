<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Pots publicados') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div wire:init="loadPosts">
            <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md m-5">
                <div class="px-6 py-4 items-center">

                    <div class="flex item-center"
                        style="    display: flex;
            justify-content: flex-end;
            align-items: center; gap: 10px; padding: 10px;">
                        <span>Mostrar </span>
                        <select wire:model="cant" class="mx-2 form-control">
                            <option value="10">10</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="100">100</option>

                        </select>
                    </div>
                    <div class="flex-1 ml-4"
                        style="
            display: flex;
            align-items: center;
            gap: 50px;">
                        <x-input type="text" wire:model="search" class="flex-1 mr-4"
                            placeholder="Escribe que quiere buscar" />
                        <div>
                            @livewire('create-post',['type' => 'general'])
                        </div>
                    </div>
                </div>


                @if (count($posts))

                    <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class=" cursor-pointer px-6 py-4 font-medium text-gray-900"
                                    wire:click="order('id')">ID</th>
                                <th scope="col" class=" cursor-pointer px-6 py-4 font-medium text-gray-900"
                                    wire:click="order('title')">Título</th>
                                <th scope="col" class=" cursor-pointer px-6 py-4 font-medium text-gray-900"
                                    wire:click="order('content')">Contenido</th>
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
                                    <td class="px-6 py-4">{!! $item->content !!}</td>
                                    <td class="px-6 py-4">

                                        <a href="#" wire:click="edit({{ $item }})"
                                            class="inline-flex items-center gap-1 bg-green-50 px-2 py-1 text-xs font-semibold text-600">
                                            <span class="h-1.5 w-1.5 bg-blue-600"> </span>
                                            Edit
                                        </a>

                                        @can('post.delete')
                                            <a href="#" class="btn btn-red ml-2"
                                                wire:click="$emit('deletePost', {{ $item }})">
                                                <i class="fas fa-trash">Eliminar</i>
                                            </a>
                                        @endcan


                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    @if ($posts->hasPages())
                        <div class="px-6 py-3">
                            {{ $posts->links() }}
                        </div>
                    @endif
                @else
                    <div class="px-6 py-4">
                        No existe ningún registro coincidente.
                    </div>

                @endif



            </div>

            <x-dialog-modal wire:model="open_edit">
                <x-slot name='title'>
                    Editar el post {{ $post->title }}
                </x-slot>

                <x-slot name='content'>

                    <div wire:loading wire:target="image"
                        class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                        role="alert">
                        <strong class="font-bold">Imagen cargando</strong>
                        <span class="block sm:inline">Espere un momento....</span>

                    </div>

                    @if ($image)
                        <img class="mb-4" src="{{ $image->temporaryUrl() }}">
                    @elseif($post->image)
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
                        <x-input-error for="image" />

                    </div>
                </x-slot>

                <x-slot name='footer'>
                    <x-secondary-button wire:click="update" wire:loading.attr="disabled" class="diabled:capacity-25">
                        Actuaizar
                    </x-secondary-button>
                    <x-danger-button wire:click="$set('open_edit', false)">
                        Cancelar
                    </x-danger-button>
                </x-slot>

            </x-dialog-modal>

            @push('js')
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                <script>
                    Livewire.on('deletePost', postId => {
                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-success',
                                cancelButton: 'btn btn-danger'
                            },
                            buttonsStyling: false
                        })

                        swalWithBootstrapButtons.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'No, cancel!',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {

                                Livewire.emitTo("show-posts", 'delete', postId);


                                swalWithBootstrapButtons.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            } else if (
                                result.dismiss === Swal.DismissReason.cancel
                            ) {
                                swalWithBootstrapButtons.fire(
                                    'Cancelled',
                                    'Your imaginary file is safe :)',
                                    'error'
                                )
                            }
                        })
                    })
                </script>
            @endpush

        </div>
    </div>
</div>
