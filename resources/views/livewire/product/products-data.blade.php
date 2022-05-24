<div>
    <x-slot name="header">
        <h2 class="text-left">List Data Product</h2>
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
                <button wire:click="createProduct()" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 mb-4 rounded">Add Product</button>
                <input class="form-control mb-3 rounded" type="text" wire:model="search" placeholder="Search" aria-label="search">
                @if($isModalOpen)
                    @include('livewire.product.form-products')
                @elseif ($isEditModalOpen)
                    @include('livewire.product.form-edit-products')
                @elseif ($isDeleteModalOpen)
                    @include('livewire.product.form-delete-products')
                @endif
                <table class="table-auto w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Product Code</th>
                            <th class="px-4 py-2">Product Name</th>
                            <th class="px-4 py-2">Categories</th>
                            <th class="px-4 py-2">Merk</th>
                            <th class="px-4 py-2">Qty</th>
                            <th class="px-4 py-2">Minim Stock</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produccts as $product)
                            <tr>
                                <td class="border px-4 py-2">{{ $product->productCode }}</td>
                                <td class="border px-4 py-2">{{ $product->productName }}</td>
                                <td class="border px-4 py-2">{{ $product->categories->categoryName }}</td>
                                <td class="border px-4 py-2">{{ $product->merk }}</td>
                                <td class="border px-4 py-2">{{ $product->qty }}</td>
                                <td class="border px-4 py-2">{{ $product->minimumStock }}</td>
                                <td class="border px-4 py-2">
                                    <button wire:click="editProduct({{ $product->id }})"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Edit</button>
                                    <button wire:click="confirmDeleteProduct({{ $product->id }})"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-4 mt-4">
                    {{$products->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
