<wireui:scripts />
<div>
    <x-slot name="header">
        <h2 class="text-left font-medium hover:font-bold">List Data Mutations
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            @include('sweetalert::alert')
                <button wire:click="formCreateMutation()" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 mb-4 rounded">Make Mutation</button>
                <input class="form-control mb-3 rounded" type="text" wire:model="search" placeholder="Search" aria-label="search">
                @if($isModalMutationsOpen)
                    @include('livewire.mutation.modal-mutation-data')
                @endif
                <table class="table-auto w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">Number</th>
                            <th class="px-4 py-2">Date</th>
                            <th class="px-4 py-2">User</th>
                            <th class="px-4 py-2">Inventory</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mutations as $mutation)
                            <tr>
                                <td class="px-4 py-2">{{ $mutation->mutationNumber }}</td>
                                <td class="px-4 py-2">{{ $mutation->mutationDate }}</td>
                                <td class="px-4 py-2">{{ $mutation->user->name }}</td>
                                <td class="px-4 py-2">{{ $mutation->inventory->inventoryCode }}</td>
                                <td class="px-4 py-2">
                                    <button wire:click="showMutation({{ $mutation->id }})" class="bg-sky-600 hover:bg-sky-800 text-white font-bold py-2 px-4 mb-4 rounded">View</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="border px-4 py-2" colspan="5">No Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-4 mt-4">
                    {{$mutations->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
