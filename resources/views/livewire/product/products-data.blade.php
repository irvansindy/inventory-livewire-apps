
<div>
    <x-slot name="header">
        <h2 class="text-left">List Data Product</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                @include('sweetalert::alert')
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
