<wireui:scripts />
<div>
    <x-slot name="header">
        <h2 class="text-left font-medium hover:font-bold">List Data Mutations
    </x-slot>
    <div class="py-12" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            @include('sweetalert::alert')
                <button wire:click="formCreateMutation()" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 mb-4 rounded">Make Mutation</button>
                <input class="form-control mb-3 rounded" type="text" wire:model="search" placeholder="Search" aria-label="search">
                @if($isModalMutationsOpen)
                    @include('livewire.mutation.modal-mutation-data')
                @elseif($isModalDetailMutationsOpen)
                    @include('livewire.mutation.detail-mutation')
                @elseif ($isModalApprovalMutationsOpen)
                    @include('livewire.mutation.approval-mutation')
                @endif
                <table class="table-auto w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Number</th>
                            <th class="px-4 py-2">Date</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">User</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mutations as $mutation)
                            <tr>
                                <td class="px-4 py-2">{{ $mutation->mutationNumber }}</td>
                                <td class="px-4 py-2">{{ $mutation->mutationDate }}</td>
                                <td class="px-4 py-2">{{ $mutation->user->name }}</td>
                                <td class="px-4 py-2">{{ $mutation->mutationStatus }}</td>
                                <td class="px-4 py-2">
                                    <button wire:click="detailMutation({{ $mutation->id }})" class="bg-sky-600 hover:bg-sky-800 text-white font-bold py-2 px-4 rounded">View</button>
                                    @can('admin')
                                        <button wire:click="viewApprovalMutation({{ $mutation->id }})" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded">Approve</button>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="border px-4 py-2" colspan="5">No Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-4">
                    {{$mutations->links()}}
                </div>
                <div x-show="open" x-transition>
                    <x-signature-pad wire:model.defer="signature"/>
                </div>
            </div>
        </div>
    </div>
</div>
