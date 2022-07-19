<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form>
                @csrf
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4 w-full">
                    <h2 class="text-2xl font-bold leading-tight text-gray-900">
                    Form Inventory Placement
                    </h2>
                </div>
                <div class="mb-4 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div>
                        <div class="mb-4">
                            <label for="placementDate"
                            class="block text-gray-700 text-sm font-bold mb-2">Date</label>
                            <input type="date"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter Date" name="placementDate"  wire:model="placementDate">
                            @error('placementDate') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="officeId"
                                class="block text-gray-700 text-sm font-bold mb-2">Location</label>
                            <select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="officeId" wire:model="officeId">
                                <option value="hidden">Select Location</option>
                                @foreach ($this->allDataLocation as $location)
                                <option value="{{ $location->id }}">{{ $location->id }} - {{ $location->officeName }}</option>
                                @endforeach
                            </select>
                            @error('officeId') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="placementDescription"
                                class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                            <textarea
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="placementDescription" wire:model="placementDescription"
                                placeholder="Enter Placement Description"></textarea>
                            @error('placementDescription') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label for="placementType"
                                class="block text-gray-700 text-sm font-bold mb-2">placement Type</label>
                            <div class="flex justify-start mr-2">
                                <div class="form-check form-check-inline mr-2">
                                    <input class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="NEW" wire:model="placementType">
                                    <label class="form-check-label inline-block text-gray-800" for="inlineRadio10">New</label>
                                </div>
                                <div class="form-check form-check-inline mr-2">
                                    <input class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="MUTATION" wire:model="placementType">
                                    <label class="form-check-label inline-block text-gray-800" for="inlineRadio20">Mutation</label>
                                </div>
                            </div>
                            @error('placementType') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-100"></div>
                <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button wire:click.prevent="storePlacementInventory" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-blue-800 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            <svg wire:loading.delay wire:target="storePlacementInventory" class="w-5 h-5 mr-3 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Placing
                        </button>
                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                        <button wire:click="closeFormPlacement()" type="button" class="inline-flex justify-center w-full rounded-md border border-red-300 px-4 py-2 bg-white text-base leading-6 font-bold text-red-500 shadow-sm hover:text-red-800 focus:outline-none focus:border-red-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Close
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>