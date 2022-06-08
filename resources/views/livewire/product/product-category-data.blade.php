<div>
    <x-slot name="header">
        <h2 class="text-left">List Data Product Categories</h2>
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
                <button wire:click="createCategory()" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 mb-4 rounded">Add Category</button>
                <input class="form-control mb-3 rounded" type="text" wire:model="search" placeholder="Search" aria-label="search">
                @if($isModalOpen)
                    @include('livewire.product.form-product-category')
                @elseif ($isEditModalOpen)
                    @include('livewire.product.form-edit-product-category')
                @elseif ($isDeleteModalOpen)
                    @include('livewire.product.form-delete-product-category')
                @endif
                <table class="table-auto w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Category Name</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td class="border px-4 py-2">{{ $category->id }}</td>
                                <td class="border px-4 py-2">{{ $category->categoryName }}</td>
                                <td class="border px-4 py-2">
                                    <button wire:click="editProductCategory({{ $category->id }})"
                                        class="bg-teal-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                                        Edit</button>
                                    <button wire:click="confirmDeleteProductCategory({{ $category->id }})"
                                        class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded">
                                        Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="border px-4 py-2">No data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-4 mt-4">
                    {{$categories->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
