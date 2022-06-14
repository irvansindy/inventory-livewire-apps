<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-12 sm:align-middle sm:max-w-screen-lg sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h5 class="text-xl font-medium leading-normal text-gray-800 mb-2">Inventory Detail</h5>
                <div class="border-t border-gray-300"></div>
                <div class="grid grid-cols-2">
                    <div>
                        <table class="table-auto">
                            <tbody>
                                <tr>
                                    <td class="px-4 py-2">Inventory Code</td>
                                    <td class="px-4 py-2">:</td>
                                    <td class="px-4 py-2">{{ $this->inventoryCode }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2">Product Name</td>
                                    <td class="px-4 py-2">:</td>
                                    <td class="px-4 py-2">{{ $this->productId }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2">Purchasing Number</td>
                                    <td class="px-4 py-2">:</td>
                                    <td class="px-4 py-2">{{ $this->purchasingNumber }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2">Serial Number</td>
                                    <td class="px-4 py-2">:</td>
                                    <td class="px-4 py-2">{{ $this->serialNumber }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2">Register Date</td>
                                    <td class="px-4 py-2">:</td>
                                    <td class="px-4 py-2">{{ $this->registeredDate }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2">Year of Entry</td>
                                    <td class="px-4 py-2">:</td>
                                    <td class="px-4 py-2">{{ $this->yearOfEntry }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <table class="table-auto">
                            <tbody>
                                <tr>
                                    <td class="px-4 py-2">Year of Use</td>
                                    <td class="px-4 py-2">:</td>
                                    <td class="px-4 py-2">{{ $this->yearOfUse }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2">Year of End</td>
                                    <td class="px-4 py-2">:</td>
                                    <td class="px-4 py-2">{{ $this->yearOfEnd }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2">Sertifikat Number</td>
                                    <td class="px-4 py-2">:</td>
                                    <td class="px-4 py-2">{{ $this->sertificateNumber }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2">Supplier</td>
                                    <td class="px-4 py-2">:</td>
                                    <td class="px-4 py-2">{{ $this->productOrigin }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2">Price</td>
                                    <td class="px-4 py-2">:</td>
                                    <td class="px-4 py-2">{{ number_format($this->productPrice,  2, ',','.') }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2">Description</td>
                                    <td class="px-4 py-2">:</td>
                                    <td class="px-4 py-2">{{ $this->productDescription }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2">Image</td>
                                    <td class="px-4 py-2">:</td>
                                    <td class="px-4 py-2"><img class="object-scale-down h-28 w-36" alt="" src="upload/images/webp/{{ $this->inventoryImageUrl }}"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                    <button wire:click="" type="button"
                        class="inline-flex justify-center w-full rounded-md border border-red-300 px-4 py-2 bg-white text-base leading-6 font-bold text-red-700 shadow-sm hover:text-red-700 focus:outline-none focus:border-red-300 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        Close
                    </button>
                </span>
            </div>
        </div>
    </div>
</div>