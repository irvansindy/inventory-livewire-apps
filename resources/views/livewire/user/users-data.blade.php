<div>
    <x-slot name="header">
        <h2 class="text-left">List Data User</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                @include('sweetalert::alert')
                <x-signature-pad wire:model="signature">
                </x-signature-pad>
                <div class="grid grid-cols-2">
                    <div>
                        <button wire:click="create()" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 mb-4 rounded">Create User</button>
                        <input class="form-control mb-3 rounded" type="text" wire:model="search" placeholder="Search" aria-label="search">
                    </div>
                    <div class="flex flex-row-reverse">
                        <button wire:click="exportPDF()" class="bg-cyan-600 hover:bg-cyan-800 text-white font-bold py-2 px-4 mb-4 rounded place-items-end">Export PDF</button>
                        <button wire:click="exportCSV()" class="bg-cyan-600 hover:bg-cyan-800 text-white font-bold py-2 px-4 mb-4 rounded place-items-end mr-2">Export CSV</button>
                        <button wire:click="modalImport()" class="bg-emerald-600 hover:bg-emerald-800 text-white font-bold py-2 px-4 mb-4 rounded place-items-end mr-2">Import CSV</button>
                    </div>
                </div>

                @if ($isModalOpen)
                    @include('livewire.user.form-users')
                @elseif ($isEditModalOpen)
                    @include('livewire.user.form-edit-users')
                @elseif ($isModalImportOpen)
                    @include('livewire.user.modal-import-user-data')
                @elseif($isSignatureOpen)
                    @include('livewire.user.signature-pad')
                @endif
                <table class="table-auto w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">NIK</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Username</th>
                            <th class="px-4 py-2">Role</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="border px-4 py-2">{{ $user->name }}</td>
                                <td class="border px-4 py-2">{{ $user->nik }}</td>
                                <td class="border px-4 py-2">{{ $user->email }}</td>
                                <td class="border px-4 py-2">{{ $user->username }}</td>
                                <td class="border px-4 py-2">{{ $user->roles }}</td>
                                <td class="border px-4 py-2">
                                    <button wire:click="editUser({{ $user->id }})"
                                        class="bg-sky-600 hover:bg-sky-800 text-white font-bold py-2 px-4 rounded">
                                        Edit</button>
                                    <button wire:click="signature({{ $user->id }})"
                                        class="bg-cyan-600 hover:bg-cyan-800 text-white font-bold py-2 px-4 rounded">
                                        Add Signature</button>
                                    {{-- <button wire:click="deleteUser({{ $user->id }})"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Delete</button> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-4 mt-4">
                    {{$users->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
