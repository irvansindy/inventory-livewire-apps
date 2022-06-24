<div>
    <x-slot name="header">
        <h2 class="text-left">List Data Product</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                @if (session()->has('message'))
                <div id="alert-3" class="flex p-4 mb-4 bg-green-100 rounded-lg dark:bg-green-200" role="alert">
                    <svg class="flex-shrink-0 w-5 h-5 text-green-700 dark:text-green-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                    <div class="ml-3 text-sm font-medium text-green-700 dark:text-green-800">
                        <p class="text-sm">{{ session('message') }}</p>
                    </div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-100 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8 dark:bg-green-200 dark:text-green-600 dark:hover:bg-green-300" data-dismiss-target="#alert-3" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
                {{-- <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                    role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('message') }}</p>
                        </div>
                    </div>
                </div> --}}
                @endif
                <button wire:click="createProduct()" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 mb-4 rounded">Add Product</button>
                <input class="form-control mb-3 rounded" type="text" wire:model="search" placeholder="Search" aria-label="search">
                @if($isModalOpen)
                    @include('livewire.product.form-products')
                @elseif ($isEditModalOpen)
                    @include('livewire.product.form-edit-products')
                @elseif ($isDeleteModalOpen)
                    @include('livewire.product.form-delete-products')
                @elseif ($isProductInventarisModalOpen)
                    @include('livewire.product.product-inventory-details')
                @elseif ($isCreateProductInventarisModalOpen)
                    @include('livewire.product.form-product-inventory')
                @elseif ($isDetailProductInventarisModalOpen)
                    @include('livewire.product.detail-product-inventory')
                @endif
                <table class="table-auto w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Product Code</th>
                            <th class="px-4 py-2">Product Name</th>
                            <th class="px-4 py-2">Categories</th>
                            <th class="px-4 py-2">Merk</th>
                            {{-- <th class="px-4 py-2">Qty</th> --}}
                            <th class="px-4 py-2">Minim Stock</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td class="border px-4 py-2">{{ $product->productCode }}</td>
                            <td class="border px-4 py-2">{{ $product->productName }}</td>
                            <td class="border px-4 py-2">{{ $product->categories->categoryName }}</td>
                            <td class="border px-4 py-2">{{ $product->merk }}</td>
                            {{-- <td class="border px-4 py-2">{{ $product->qty }}</td> --}}
                            <td class="border px-4 py-2">{{ $product->minimumStock }}</td>
                            <td class="border px-4 py-2">
                                <button wire:click="editProduct({{ $product->id }})"
                                    class="bg-teal-600 hover:bg-teal-800 text-white font-bold py-2 px-4 rounded">
                                    Edit</button>
                                <button wire:click="viewProductInventaries({{ $product->id }})"
                                    class="bg-sky-600 hover:bg-sky-800 text-white font-bold py-2 px-4 rounded">
                                    View Inventory</button>
                                {{-- <button wire:click="confirmDeleteProduct({{ $product->id }})"
                                    class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded">
                                    Delete</button> --}}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="border px-4 py-2">No Data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-4 mt-4">
                    {{$products->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
