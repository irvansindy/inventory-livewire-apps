<div>
    <x-slot name="header">
        <h2 class="text-left">List Data Inventaries</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                @include('sweetalert::alert')
                <div class="grid grid-cols-2">
                    <div>
                        <input class="form-control mb-3 rounded" type="text" wire:model="search" placeholder="Search" aria-label="search">
                    </div>
                    <div class="flex flex-row-reverse">
                        {{-- <button wire:click="" class="bg-cyan-600 hover:bg-cyan-800 text-white font-bold py-2 px-4 mb-4 rounded place-items-end">Export PDF</button> --}}
                        <button wire:click="exportCSV" class="bg-cyan-600 hover:bg-cyan-800 text-white font-bold py-2 px-4 mb-4 rounded place-items-end mr-2">Export CSV</button>
                    </div>
                </div>
                @if($isModalOpen)
                    @include('livewire.product.detail-inventaries-data')
                    @elseif($isMutationOpen)
                    @include('livewire.product.mutation.form-mutation-inventory')

                @endif
                <table class="table-auto w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Inventory Code</th>
                            <th class="px-4 py-2">Product Name</th>
                            <th class="px-4 py-2">Merk</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventaries as $inventory)  
                        <tr>
                            <td class="border px-4 py-2">{{ $inventory->inventoryCode }}</td>
                            <td class="border px-4 py-2">{{ $inventory->products->productName }}</td>
                            <td class="border px-4 py-2">{{ $inventory->products->merk }}</td>
                            <td class="border px-4 py-2">Rp.{{ number_format($inventory->productPrice, 2, ',','.') }}</td>
                            <td class="border px-4 py-2">{{ $inventory->productStatus }}</td>
                            <td class="border px-4 py-2">
                                @if ($inventory->productStatus == 'AVAILABLE')
                                <button wire:click="detailInventory({{ $inventory->id }})"
                                    class="bg-sky-600 hover:bg-sky-800 text-white font-bold py-2 px-4 rounded">
                                    Detail</button>
                                @else
                                    <button wire:click="detailInventory({{ $inventory->id }})"
                                        class="bg-sky-600 hover:bg-sky-800 text-white font-bold py-2 px-4 rounded">
                                        Detail</button>
                                    <button wire:click="openMutation({{ $inventory->id }})"
                                        class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded">
                                        Mutations</button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="border px-4 py-2">No data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-4 mt-4">
                    {{$inventaries->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
