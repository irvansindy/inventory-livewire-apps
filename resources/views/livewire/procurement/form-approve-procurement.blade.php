<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-12 sm:align-middle sm:max-w-screen-lg sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <form>
                @csrf
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4 w-full">
                    <h2 class="text-2xl font-bold leading-tight text-gray-900">
                        Form Procurement Data
                    </h2>
                </div>
                <div class="border-t border-gray-300"></div>
                <div>
                    <div class="my-4">
                        <h5 class="text-xl font-semibold leading-normal text-gray-800 mb-2">Procurement Detail</h5>
                        <table class="table-auto w-full">
                            <thead>
                                <tr>
                                    <th class="px-2 py-1">Product Name</th>
                                    <th class="px-2 py-1">Description</th>
                                    <th class="px-2 py-1">Qty</th>
                                    <th class="px-2 py-1">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($this->procurementDetails as $detailItem)
                                <tr>
                                    <td class="px-2 py-1">{{ $detailItem->product->productName }}</td>
                                    <td class="px-2 py-1">{{ $detailItem->description }}</td>
                                    <td class="px-2 py-1">{{ $detailItem->quantity }}</td>
                                    <td class="px-2 py-1">{{ number_format($detailItem->unitPrice, 2, ',','.') }}</td>
                                </tr>
                                @empty
                                    <tr>
                                        <td class="px-2 py-1 hover:font-semibold" colspan="4">No data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="border-t border-gray-300"></div>
                    {{-- form approval --}}
                    <div class="grid grid-cols-2 my-4">
                        <div>
                            <div class="mr-4">
                                <label for="commentApproval"
                                    class="block text-gray-700 text-sm font-bold mb-2">Note or Comment for {{ $this->approvalId }}</label>
                                <textarea
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="commentApproval" wire:model="commentApproval" placeholder="Note or Comment">
                                </textarea>
                                @error('commentApproval') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div>
                            <div class="ml-4">
                                <x-signature-pad wire:model.defer="procurementSignatureUser"/>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button wire:click.prevent="storeAndUpdateStaggingApprovalProcurement()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-sky-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-sky-800 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                <svg wire:loading.delay wire:target="storeAndUpdateStaggingApprovalProcurement" class="w-5 h-5 mr-3 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Approved
                            </button>
                        </span>
                        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                            <button wire:click="cancelApproval" type="button" class="inline-flex justify-center w-full rounded-md border border-red-300 px-4 py-2 bg-white text-base leading-6 font-bold text-red-700 shadow-sm hover:text-red-700 hover:bg-grey-300 focus:outline-none focus:border-red-300 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Cancel
                            </button>
                        </span>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>