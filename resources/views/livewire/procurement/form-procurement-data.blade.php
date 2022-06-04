<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-screen-lg sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
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
                                {{-- @foreach ($dataSupplier as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->supplierName }}</option>
                                @endforeach --}}
                            </select>
                            @error('supplierId') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="procurementTypeId"
                                class="block text-gray-700 text-sm font-bold mb-2">Procurement Type</label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="procurementTypeId" id="procurementTypeId" wire:model="procurementTypeId">
                                <option value="hidden">Select Types</option>
                                {{-- @foreach ($dataSupplier as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->supplierName }}</option>
                                @endforeach --}}
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
                <div class="border-t border-gray-100"></div>
                <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button wire:click.prevent="" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-blue-800 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Delete
                        </button>
                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                        <button wire:click="closeModal()" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-red-300 px-4 py-2 bg-white text-base leading-6 font-bold text-red-500 shadow-sm hover:text-red-800 focus:outline-none focus:border-red-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Close
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>