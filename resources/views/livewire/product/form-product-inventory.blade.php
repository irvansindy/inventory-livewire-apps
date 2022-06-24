<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>?
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form enctype="multipart/form-data">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    @if (session()->has('error'))
                        <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md my-3"
                            role="alert">
                            <div class="flex">
                                <div>
                                    <p class="text-sm">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="">
                        <div class="mb-4">
                            <label for="purchasingNumber"
                                class="block text-gray-700 text-sm font-bold mb-2">Purchasing Number</label>
                            <input type="text"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="purchasingNumber" placeholder="Enter Purchasing Number" wire:model="purchasingNumber">
                            @error('purchasingNumber') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="serialNumber"
                                class="block text-gray-700 text-sm font-bold mb-2">Serial Number</label>
                            <input type="text"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="serialNumber" placeholder="Enter Serial Number" wire:model="serialNumber">
                            @error('serialNumber') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="sertificateNumber"
                                class="block text-gray-700 text-sm font-bold mb-2">Sertificate Number</label>
                            <input type="text"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="sertificateNumber" placeholder="Enter Sertificate Number" wire:model="sertificateNumber">
                            @error('sertificateNumber') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="productOrigin"
                                class="block text-gray-700 text-sm font-bold mb-2">Product Origin (Supplier)</label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="productOrigin" id="productOrigin" wire:model="productOrigin">
                                <option value="hidden">Select Product Origin</option>
                                @foreach ($dataSupplier as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->supplierName }}</option>
                                @endforeach
                            </select>
                            @error('productOrigin') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="productPrice"
                                class="block text-gray-700 text-sm font-bold mb-2">Product Price</label>
                            <input type="number"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="productPrice" placeholder="Enter Product Price" wire:model="productPrice">
                            @error('productPrice') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="productDescription2"
                                class="block text-gray-700 text-sm font-bold mb-2">Product Description</label>
                            <input type="text"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="productDescription2" placeholder="Enter Product Description" wire:model="productDescription2">
                            @error('productDescription2') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="inventoryImageUrl"
                                class="block text-gray-700 text-sm font-bold mb-2">Upload Product Image</label>
                            <input type="file"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="inventoryImageUrl" placeholder="Enter Product Description" wire:model="inventoryImageUrl">
                            @error('inventoryImageUrl') <span class="text-red-500">{{ $message }}</span>@enderror
                            <div wire:loading.delay wire:target="inventoryImageUrl">
                                <span class="text-blue-400">
                                    Processing Upload Data...
                                </span>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="registeredDate"
                                class="block text-gray-700 text-sm font-bold mb-2">Register Date</label>
                            <input type="date"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="registeredDate" placeholder="Enter Register Date" wire:model="registeredDate">
                            @error('registeredDate') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="yearOfEntry"
                                class="block text-gray-700 text-sm font-bold mb-2">Year of Entry</label>
                            <input type="date"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="yearOfEntry" placeholder="Enter Register Date" wire:model="yearOfEntry">
                            @error('yearOfEntry') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="yearOfUse"
                                class="block text-gray-700 text-sm font-bold mb-2">Year of Use</label>
                            <input type="date"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="yearOfUse" placeholder="Enter Register Date" wire:model="yearOfUse">
                            @error('yearOfUse') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="yearOfEnd"
                                class="block text-gray-700 text-sm font-bold mb-2">Year of End</label>
                            <input type="date"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="yearOfEnd" placeholder="Enter Register Date" wire:model="yearOfEnd">
                            @error('yearOfEnd') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button wire:click.prevent="storeInventory()" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-sky-300 px-4 py-2 bg-sky-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-sky-800 focus:outline-none focus:border-sky-300 focus:shadow-outline-sky transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            <svg wire:loading.delay wire:target="storeInventory" class="w-5 h-5 mr-3 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Save
                        </button>
                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                        <button wire:click="closeInventory({{ $this->productId }})" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-red-300 px-4 py-2 bg-white text-base leading-6 font-bold text-red-600 shadow-sm hover:text-red-800 focus:outline-none focus:border-red-500 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Close
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>