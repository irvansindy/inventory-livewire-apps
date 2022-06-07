<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-12 sm:align-middle sm:max-w-screen-lg sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h5 class="text-xl font-medium leading-normal text-gray-800 mb-2">Product Inventory Details</h5>
                <div class="border-t border-gray-300"></div>
                <table class="table-auto">
                    <tbody>
                        <tr>
                            <td class="px-4 py-2">Product Name</td>
                            <td class="px-4 py-2">:</td>
                            <td class="px-4 py-2">{{ $this->productName }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2">Product Code</td>
                            <td class="px-4 py-2">:</td>
                            <td class="px-4 py-2">{{ $this->productCode }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2">Category</td>
                            <td class="px-4 py-2">:</td>
                            <td class="px-4 py-2">{{ $this->categoryId }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2">Merk</td>
                            <td class="px-4 py-2">:</td>
                            <td class="px-4 py-2">{{ $this->merk }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2">Description</td>
                            <td class="px-4 py-2">:</td>
                            <td class="px-4 py-2">{{ $this->productDescription }}</td>
                        </tr>
                    </tbody>
                </table>
                <button wire:click="createInventory({{ $this->productId }})" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 my-4 rounded">Add Inventory</button>
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-2 py-1">Inventory Code</th>
                            <th class="px-2 py-1">Serial Number</th>
                            <th class="px-2 py-1">Price</th>
                            <th class="px-2 py-1">Status</th>
                            <th class="px-2 py-1">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($this->productInventory as $inventory => $valueInventory)
                            @forelse ($valueInventory as $inventoryItems)
                                <tr>
                                    <td class="px-2 py-1">{{ $inventoryItems->inventoryCode }}</td>
                                    <td class="px-2 py-1">{{ $inventoryItems->serialNumber }}</td>
                                    <td class="px-2 py-1">{{ $inventoryItems->productPrice }}</td>
                                    <td class="px-2 py-1">{{ $inventoryItems->productStatus }}</td>
                                    
                                    <td class="px-2 py-1">
                                        <button class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 my-4 rounded" wire:click="">Detail</button>
                                    </td>
                                </tr>  
                            @empty
                                <tr>
                                    <td colspan="5" class="px-2 py-1">No data</td>
                                </tr>
                            @endforelse
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                    <button wire:click="closeModal()" type="button"
                        class="inline-flex justify-center w-full rounded-md border border-red-300 px-4 py-2 bg-white text-base leading-6 font-bold text-red-700 shadow-sm hover:text-red-700 focus:outline-none focus:border-red-300 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        Close
                    </button>
                </span>
            </div>
        </div>
    </div>
</div>