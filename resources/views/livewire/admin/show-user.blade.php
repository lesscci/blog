<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Lista de usuarios
                </h2>
            </x-slot>
            <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md m-5">
                <div class="px-6 py-4 items-center">

                    <div class="flex item-center"
                        style="    display: flex;
            justify-content: flex-end;
            align-items: center; gap: 10px; padding: 10px;">
                        <span>Mostrar </span>
                        <select wire:model="cant" class="mx-2 form-control">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
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
                    </div>
                </div>

                @if (count($users))
                    <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class=" cursor-pointer px-6 py-4 font-medium text-gray-900"
                                    wire:click="order('id')">ID</th>
                                <th scope="col" class=" cursor-pointer px-6 py-4 font-medium text-gray-900"
                                    wire:click="order('title')">Nombre</th>
                                <th scope="col" class=" cursor-pointer px-6 py-4 font-medium text-gray-900"
                                    wire:click="order('content')">Dirección</th>
                                <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 border-t border-gray-100">

                            @foreach ($users as $item)
                                @if ($item->id !== Auth::id())
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-green-600">
                                                <span class="h-1.5 w-1.5 rounded-full bg-green-600"></span>
                                                {{ $item->name }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">{{ $item->name }}</td>
                                        <td class="px-6 py-4">{{ $item->email }}</td>
                                        <td class="px-6 py-4">

                                            
                                             @livewire('edit-user', ['user' => $item], key($item->id))

                                            <a href="#" class="btn btn-red ml-2"
                                                wire:click="$emit('deleteUser', {{ $item }})">
                                                <i class="fas fa-trash">Eliminar</i>
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                        </tbody>
                    </table>

                    @if ($users->hasPages())
                        <div class="px-6 py-3">
                            {{ $users->links() }}
                        </div>
                    @endif
                @else
                    <div class="px-6 py-4">
                        No existe ningún registro coincidente.
                    </div>
                @endif


            </div>

        </div>
    </div>
</div>
