<div>
    <x-slot name="header">
        <h2 class="text-left hover:font-semibold">List Data Supplier</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                @include('sweetalert::alert')
                <div class="grid grid-cols-2">
                    <div>
                        <button wire:click="createSupplier()" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 mb-4 rounded">Add Supplier</button>
                        <input class="form-control mb-3 rounded" type="text" wire:model="search" placeholder="Search" aria-label="search">
                    </div>
                    <div class="flex flex-row-reverse">
                        <button wire:click="openModalImport" class="bg-cyan-600 hover:bg-cyan-800 text-white font-bold py-2 px-4 mb-4 rounded place-items-end mr-2">Import</button>
                    </div>
                </div>
                @if($isModalOpen)
                    @include('livewire.supplier.form-supplier')
                @elseif($isModalImportOpen  )
                    @include('livewire.supplier.modal-import-supplier-data')
                @endif
                <table class="table-auto w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Supplier Name</th>
                            <th class="px-4 py-2">Supplier Address</th>
                            <th class="px-4 py-2">Phone Number</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suppliers as $supplier)
                            <tr>
                                <td class="border px-4 py-2">{{ $supplier->supplierName }}</td>
                                <td class="border px-4 py-2">{{ $supplier->supplierAddress }}</td>
                                <td class="border px-4 py-2">{{ $supplier->supplierNumber }}</td>
                                
                                <td class="border px-4 py-2">
                                    <button wire:click=""
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Edit</button>
                                    <button wire:click=""
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- <div class="px-4 mt-4">
                    {{$inventaries->links()}}
                </div> --}}
            </div>
        </div>
    </div>
</div>
