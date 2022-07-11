<div>
    <x-slot name="header">
        <h2 class="text-left">List Data Procurement</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('sweetalert::alert')
            <div x-data="{open: false}" class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                {{-- list data table --}}
                <div x-show="!open">
                    {{-- wire:click="addProcurement()" --}}
                    <button x-on:click="open = !open"  class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 mb-4 rounded">Make Procurement</button>
                    {{-- <button wire:click="addProcurement"  class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 mb-4 rounded">Make Procurement</button> --}}
                    <input class="form-control mb-3 rounded" type="text" wire:model="search" placeholder="Search" aria-label="search">
                    @if($isModalOpen)
                        @include('livewire.procurement.form-procurement-data')
                    @elseif($isDetailProcurement)
                        @include('livewire.procurement.detail-procurement')
                    @elseif($isApproveModalOpen)
                        @include('livewire.procurement.approve-procurement')
                    @elseif($isDetailApproveModalOpen)
                        @include('livewire.procurement.form-approve-procurement')
                    {{-- @elseif($isDoneModalOpen)
                        @include('livewire.procurement.done-procurement-data') --}}
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
                                    @if ($procurement->status == 0 && Auth::user()->roles != 'USER')
                                    {{-- && Auth::user()->roles != 'USER' --}}
                                    <button wire:click="detailProcurement({{ $procurement->id }})" class="bg-sky-600 hover:bg-sky-800 text-white font-bold py-2 px-4 rounded">Detail</button>
                                    {{-- <button wire:click="doneProcurement({{ $procurement->id }})" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded">Done</button> --}}
                                    {{-- <button wire:click="approveProcurement({{ $procurement->id }})" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded">Approve</button> --}}
                                    <button wire:click="detailApproval({{ $procurement->id }})" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded">Approve</button>
                                    @else
                                    <button wire:click="detailProcurement({{ $procurement->id }})" class="bg-sky-600 hover:bg-sky-800 text-white font-bold py-2 px-4 rounded">Detail</button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="border px-4 py-2"><p class="text-justify-center hover:font-bold">No Data</p></td>
                            </tr>
                            @endforelse
                        </tbody>
                        @endif
                    </table>
                    <div class="px-4 mt-4">
                        {{$procurements->links()}}
                    </div>
                </div>
                {{-- form add procurement --}}
                <div x-show="open">
                    <form>
                        <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4 w-full">
                            <h2 class="text-2xl font-bold leading-tight text-gray-900">
                                Form Procurement Data
                            </h2>
                        </div>
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="">
                                <div class="mb-4">
                                    <label for="supplierId"
                                        class="block text-gray-700 text-sm font-bold mb-2">Supplier</label>
                                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="supplierId" id="supplierId" wire:model="supplierId">
                                        <option value="hidden">Select Product Origin</option>
                                        @foreach ($this->dataSupplier as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->supplierName }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplierId') <span class="text-red-500">{{ $message }}</span>@enderror
                                </div>
                                <div class="mb-4">
                                    <label for="procurementTypeId"
                                        class="block text-gray-700 text-sm font-bold mb-2">Procurement Type</label>
                                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="procurementTypeId" id="procurementTypeId" wire:model="procurementTypeId">
                                        <option value="hidden">Select Types</option>
                                        @foreach ($this->dataProcurementType as $type)
                                        <option value="{{ $type->id }}">{{ $type->procurementTypeName }}</option>
                                        @endforeach
                                    </select>
                                    @error('procurementTypeId') <span class="text-red-500">{{ $message }}</span>@enderror
                                </div>
                                <div class="mb-4">
                                    <label for="procurementDescription"
                                        class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                                    <textarea
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="procurementDescription" wire:model="procurementDescription"
                                        placeholder="Enter Product Description"></textarea>
                                    @error('procurementDescription') <span class="text-red-500">{{ $message }}</span>@enderror
                                </div>
                                <div class="mb-4">
                                    <label for="procurementDate"
                                        class="block text-gray-700 text-sm font-bold mb-2">Date of Procurement</label>
                                    <input type="date"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="procurementDate" placeholder="Enter Register Date" wire:model="procurementDate">
                                    @error('procurementDate') <span class="text-red-500">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                        {{-- divider --}}
                        <div class="border-t border-gray-100"></div>
                        <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4 w-full">
                            <h5 class="text-xl font-bold leading-tight text-gray-900">
                                Product Details
                            </h5>
                        </div>
                        {{-- add dynamic form --}}
                        @foreach ($orderProcurements as $index => $orderProcurement)
                        <div class="grid grid-cols-6 gap-4 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="mr-1">
                                <select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="productId" name="orderProcurements[{{ $index }}][productId]" wire:model="orderProcurements.{{ $index }}.productId">
                                    <option value="hidden">Select Product</option>
                                    @foreach ($allProducts as $product)
                                    <option value="{{ $product->id }}">{{ $product->productName }}</option>
                                    @endforeach
                                </select>
                                @error('orderProcurements.{{ $index }}.productId') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div class="mr-1">
                                <input type="text"
                                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Product Name" name="orderProcurements[{{ $index }}][description]"  wire:model="orderProcurements.{{ $index }}.description">
                                @error('orderProcurements.{{ $index }}.description') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            
                            <div class="mr-1">
                                <input type="number" min="1" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"placeholder="Price" name="orderProcurements[{{ $index }}][unitPrice]" wire:model="orderProcurements.{{ $index }}.unitPrice">
                                @error('orderProcurements.{{ $index }}.unitPrice') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            
                            <div class="mr-1">
                                <input type="number" min="1" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"placeholder="Quantity" name="orderProcurements[{{ $index }}][quantity]" wire:model="orderProcurements.{{ $index }}.quantity">
                                @error('orderProcurements.{{ $index }}.quantity') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
        
                            <div class="mr-1">
                                <input type="file"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="orderProcurements.{{ $index }}.inventoryImageUrl" name="orderProcurements.{{ $index }}.inventoryImageUrl" wire:model="orderProcurements.{{ $index }}.inventoryImageUrl">
                                @error('orderProcurements.{{ $index }}.inventoryImageUrl') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
        
                            <div class="mr-1 justify-end sm:flex sm:flex-row-reverse">
                                <button class="inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-red-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150" wire:click.prevent="removeProductProcurement({{ $index }})">Delete</button>
                            </div>
                        </div>
                        @endforeach
                        <div class="mb-4 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <button class="inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" wire:click.prevent="addProductProcurement">Add Another Product</button>
                        </div>
                        {{-- component signature pad --}}
                        <x-signature-pad wire:model.defer="procurementSignatureUser"/>
                        {{-- component signature pad --}}
                        <div class="border-t border-gray-100"></div>
                        <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <button wire:click.prevent="storeProcurement()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-sky-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-sky-800 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                    <svg wire:loading.delay wire:target="storeProcurement" class="w-5 h-5 mr-3 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Save
                                </button>
                            </span>
                            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                <button x-on:click="open = !open" type="button" class="inline-flex justify-center w-full rounded-md border border-red-300 px-4 py-2 bg-white text-base leading-6 font-bold text-red-500 shadow-sm hover:text-red-800 focus:outline-none focus:border-red-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                    Close
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
