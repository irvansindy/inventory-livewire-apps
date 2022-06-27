<div>
    <x-slot name="header">
        <h2 class="text-left">List Data Loan</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                @include('sweetalert::alert')

                <button wire:click="createModalLoan()" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 mb-4 rounded">Create Loan</button>
                <input class="form-control mb-3 rounded" type="text" wire:model="search" placeholder="Search" aria-label="search">
                @if($isModalLoanOpen)
                    @include('livewire.loan.modal-loan-data')
                @elseif($isformCreateModalOpen)
                    @include('livewire.loan.form-loan-data')
                @elseif ($isDetailLoanOpen)
                    @include('livewire.loan.detail-loan-data')
                @elseif ($isReturnLoanOpen)
                    @include('livewire.loan.modal-return-loan-data')
                @endif
                <table class="table-auto w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">Loan Code</th>
                            <th class="px-4 py-2">User</th>
                            <th class="px-4 py-2">Location</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($loans as $loan)
                            <tr>
                                <td class="border px-4 py-2">{{ $loan->loanCode }}</td>
                                <td class="border px-4 py-2">{{ $loan->user->name }}</td>
                                <td class="border px-4 py-2">{{ $loan->location->locationName }}</td>
                                <td class="border px-4 py-2">{{ $loan->status }}</td>
                                @if ($loan->status == 'LOANED')
                                    <td class="border px-4 py-2">
                                        <button wire:click="detailLoan({{ $loan->id }})" class="bg-sky-600 hover:bg-sky-800 text-white font-bold py-2 px-4 mb-4 rounded">Detail</button>
                                        <button wire:click="confirmReturn({{ $loan->id }})" class="bg-teal-600 hover:bg-teal-800 text-white font-bold py-2 px-4 mb-4 rounded">Return</button>
                                    </td>
                                @else
                                    <td class="border px-4 py-2">
                                        <button wire:click="detailLoan({{ $loan->id }})" class="bg-sky-600 hover:bg-sky-800 text-white font-bold py-2 px-4 mb-4 rounded">Detail</button>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td class="border px-4 py-2" colspan="5">No Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-4 mt-4">
                    {{$loans->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
