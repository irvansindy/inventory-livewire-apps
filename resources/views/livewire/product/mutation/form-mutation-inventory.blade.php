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
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="">
                        <div class="mb-4">
                            <label for="inventoryCode"
                                class="block text-gray-700 text-sm font-bold mb-2">Inventory Code</label>
                            <input type="text"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="inventoryCode" placeholder="Inventory Code" wire:model="inventoryCode" readonly value="{{ $this->inventoryIdMutation }}">
                            @error('inventoryCode') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="mutationDate"
                                class="block text-gray-700 text-sm font-bold mb-2">Mutation Date</label>
                            <input type="date"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="mutationDate" placeholder="Inventory Code" wire:model="mutationDate">
                            @error('mutationDate') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="grid grid-cols-2">
                            <div class="mb-4 mr-1">
                                <label for="locationInventoryNameNow"
                                    class="block text-gray-700 text-sm font-bold mb-2">Location Now</label>
                                @if ($this->locationInventoryIdNow && $this->locationInventoryNameNow !== NULL)
                                    <input type="text"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="locationInventoryNameNow" placeholder="Inventory Code" wire:model="locationInventoryNameNow" readonly value="{{ $this->locationInventoryIdNow }}">
                                @else
                                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="locationInventoryNameNow" id="locationInventoryNameNow" wire:model="locationInventoryNameNow">
                                        @foreach ($allDataLocation as $location)
                                            <option value="{{ $location->id }}">{{ $location->officeName }}</option>
                                        @endforeach
                                    </select>
                                @endif
                                @error('locationInventoryNameNow') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-4 ml-1">
                                <label for="mutationToLocationId" class="block text-gray-700 text-sm font-bold mb-2">Mutation To</label>
                                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="mutationToLocationId" id="mutationToLocationId" wire:model="mutationToLocationId">
                                    <option value="hidden">Select Location</option>
                                    @foreach ($allDataOffice as $location)
                                    <option value="{{ $location->id }}">{{ $location->officeName }}</option>
                                    @endforeach
                                </select>
                                @error('mutationToLocationId') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="mutationDescription"
                                class="block text-gray-700 text-sm font-bold mb-2">Mutation Description</label>
                            <textarea
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="mutationDescription" wire:model="mutationDescription"
                                placeholder="Enter Description"></textarea>
                            @error('mutationDescription') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button wire:click.prevent="storeMutation()" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-sky-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-sky-800 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Mutations
                        </button>
                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                        <button wire:click="closeMutation" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-bold text-gray-700 shadow-sm hover:text-gray-700 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Cancel
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>