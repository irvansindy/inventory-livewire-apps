<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-12 sm:align-middle sm:max-w-lg sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h5 class="text-xl font-semibold leading-normal text-gray-800 mb-2">Confirm Return Placement</h5>
                <div class="border-t border-gray-300"></div>
                <h2 class="text-2xl font-bold leading-tight text-gray-900">
                    Return Inventory {{ $this->inventoryCode }}
                </h2>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                    <button wire:click="returnPlacementInventory()" type="button"
                        class="inline-flex justify-center w-full rounded-md border border-sky-300 px-4 py-2 bg-white text-base leading-6 font-bold text-sky-700 shadow-sm hover:text-sky-700 hover:bg-grey-300 focus:outline-none focus:border-sky-300 focus:shadow-outline-sky transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        Confirm
                    </button>
                </span>
                <span class="mt-3 mr-2 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                    <button wire:click="closeReturn" type="button"
                        class="inline-flex justify-center w-full rounded-md border border-red-300 px-4 py-2 bg-white text-base leading-6 font-bold text-red-700 shadow-sm hover:text-red-700 hover:bg-grey-300 focus:outline-none focus:border-red-300 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        Close
                    </button>
                </span>
            </div>
        </div>
    </div>
</div>