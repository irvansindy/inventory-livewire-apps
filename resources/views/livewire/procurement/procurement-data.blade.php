<div>
    <x-slot name="header">
        <h2 class="text-left">List Data Procurement</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                @if (session()->has('message'))
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                    role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
                @endif
                <button wire:click="addProcurement()" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 mb-4 rounded">Make Procurement</button>
                <input class="form-control mb-3 rounded" type="text" wire:model="search" placeholder="Search" aria-label="search">
                @if($isModalOpen)
                    @include('livewire.procurement.form-procurement-data')
                @endif
                <table class="table-auto w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Procurement Code</th>
                            <th class="px-4 py-2">User</th>
                            <th class="px-4 py-2">Supplier</th>
                            <th class="px-4 py-2">Type</th>
                            <th class="px-4 py-2">Total Price</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    @if (empty($procurements))
                    <tbody>
                        <tr>
                            <td colspan="6" class="text-center">No Data</td>
                        </tr>
                    </tbody>
                    @else
                    <tbody>
                        @forelse ($procurements as $procurement)
                        <tr>
                            <td class="border px-4 py-2">{{ $procurement->procurementCode }}</td>
                            <td class="border px-4 py-2">{{ $procurement->user->name }}</td>
                            <td class="border px-4 py-2">{{ $procurement->supplier->supplierName }}</td>
                            <td class="border px-4 py-2">{{ $procurement->procurementType->procurementTypeName }}</td>
                            <td class="border px-4 py-2">Rp.{{ number_format($procurement->totalPrice, 2, ',','.') }}</td>
                            <td class="border px-4 py-2">
                                {{ $procurement->status == 0 ? 'PENDING' : 'DONE' }}
                            </td>
                            <td class="border px-4 py-2">
                                <button wire:click="editProcurement({{ $procurement->id }})" class="bg-sky-600 hover:bg-sky-800 text-white font-bold py-2 px-4 rounded">Detail</button>
                                {{-- <button wire:click="deleteProcurement({{ $procurement->id }})" class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded">Delete</button> --}}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="border px-4 py-2">No data</td>
                        </tr>
                        @endforelse
                    </tbody>
                    @endif
                </table>
                <div class="px-4 mt-4">
                    {{$procurements->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
