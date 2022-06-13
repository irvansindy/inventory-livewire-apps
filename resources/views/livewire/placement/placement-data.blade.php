<div>
    <x-slot name="header">
        <h2 class="text-left">List Data Placement Inventory</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                @if (session()->has('message'))
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                    role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
                @endif
                <button wire:click="" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 mb-4 rounded">Make Placement</button>
                <input class="form-control mb-3 rounded" type="text" wire:model="search" placeholder="Search" aria-label="search">
                {{-- @if($isModalOpen)
                    @include('livewire.procurement.form-procurement-data')
                @elseif($isDetailProcurement)
                    @include('livewire.procurement.detail-procurement')
                @endif --}}
                <table class="table-auto w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Placement Date</th>
                            <th class="px-4 py-2">User</th>
                            <th class="px-4 py-2">Location</th>
                            <th class="px-4 py-2">Type</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @forelse ($procurements as $procurement) --}}
                        <tr>
                            <td class="border px-4 py-2"></td>
                            <td class="border px-4 py-2"></td>
                            <td class="border px-4 py-2"></td>
                            <td class="border px-4 py-2"></td>
                            <td class="border px-4 py-2">
                                <button wire:click="" class="bg-sky-600 hover:bg-sky-800 text-white font-bold py-2 px-4 rounded">Detail</button>
                            </td>
                        </tr>
                        {{-- @empty --}}
                        <tr>
                            <td colspan="7" class="border px-4 py-2"><p class="text-justify-center hover:font-bold">No Data</p></td>
                        </tr>
                        {{-- @endforelse --}}
                    </tbody>
                </table>
                {{-- <div class="px-4 mt-4">
                    {{$procurements->links()}}
                </div> --}}
            </div>
        </div>
    </div>
</div>
