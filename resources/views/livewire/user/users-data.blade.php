<div>
    <x-slot name="header">
        <h2 class="text-left">List Data User</h2>
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
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                    </div>
                </div>
                @endif
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
