<div>
    <x-slot name="header">
        <h2 class="text-left hover:font-bold">List Data Placement Inventory</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                @include('sweetalert::alert')
                <button wire:click="createPlacement()" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 mb-4 rounded">Make Placement</button>
                <input class="form-control mb-3 rounded" type="text" wire:model="search" placeholder="Search" aria-label="search">
                @if($isModalPlacementOpen)
                    @include('livewire.placement.modal-placement-data')
                @elseif($isformCreateModalOpen)
                    @include('livewire.placement.form-placement-data')
                @elseif($isDetailPlacementOpen)
                    @include('livewire.placement.detail-placement-data')
                @elseif($isReturnPlacementOpen)
                    @include('livewire.placement.modal-return-placement-data')
                @endif
                <table class="table-auto w-full">
                    <thead>
                        <tr class="bg-gray-100 rounded">
                            <th class="px-4 py-2">Placement Date</th>
                            <th class="px-4 py-2">User</th>
                            <th class="px-4 py-2">Location</th>
                            <th class="px-4 py-2">Type</th>
                            <th class="px-4 py-2">status</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($placements as $placement)
                        <tr>
                            <td class="border px-4 py-2">{{ $placement->placementDate }}</td>
                            <td class="border px-4 py-2">{{ $placement->user->name }}</td>
                            <td class="border px-4 py-2">{{ $placement->location->locationName }}</td>
                            <td class="border px-4 py-2">{{ $placement->placementType }}</td>
                            <td class="border px-4 py-2">{{ $placement->placementDetails[0]->status }}</td>
                            <td class="border px-4 py-2">
                                @if ($placement->placementDetails[0]->status == 'INACTIVE')
                                    <button wire:click="detailPlacement({{ $placement->id }})" class="bg-sky-600 hover:bg-sky-800 text-white font-bold py-2 px-2 rounded">Detail</button>
                                @else
                                    <button wire:click="detailPlacement({{ $placement->id }})" class="bg-sky-600 hover:bg-sky-800 text-white font-bold py-2 px-2 rounded">Detail</button>
                                    <button wire:click="confirmReturn({{ $placement->id }})" class="bg-teal-600 hover:bg-teal-800 text-white font-bold py-2 px-2 rounded">Return</button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="border px-4 py-2"><p class="text-justify-center hover:font-bold">No Data</p></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-4 mt-4">
                    {{$placements->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
