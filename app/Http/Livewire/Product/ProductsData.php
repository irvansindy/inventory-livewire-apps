<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Products;
use App\Models\ProductCategories;

class ProductsData extends Component
{
    public $allDataProduct, $productId, $productCode, $productName, $categoryId, $productDescription, $merk, $qty, $minimumStock;
    public $search;
    public $dataCategory;
    public $isModalOpen = 0;
    public $isEditModalOpen = 0;
    public $isDeleteModalOpen = 0;
    public $isProductInventarisModalOpen = 0;
    public $limitPerPage = 10;
    protected $queryString = ['search'=> ['except' => '']];
    protected $listeners = [
        'products' => 'productPostData'
    ];

    public function productPostData() {
        $this->limitPerPage = $this->limitPerPage + 1;  
    }

    public function render()
    {

        $product = Products::latest()->paginate($this->limitPerPage);

        if($this->search !== null) {
            // $product = Products::with('ProductCategories')->whereHas('ProductCategories', function($query) {
            $product = Products::with('categories')->whereHas('categories', function($query) {
                $query->where('productName', 'LIKE', '%'.$this->search.'%')
                ->orWhere('productCode',  'LIKE', '%'.$this->search.'%')
                ->orWhere('productDescription',  'LIKE', '%'.$this->search.'%')
                ->orWhere('merk',  'LIKE', '%'.$this->search.'%')
                ->orWhere('qty',  'LIKE', '%'.$this->search.'%')
                ->orWhere('minimumStock',  'LIKE', '%'.$this->search.'%');
            })->paginate($this->limitPerPage);
        }

        $this->emit('productPostData');

        return view('livewire.product.products-data', ['products' => $product]);

    }

    public function openModal() {
        $this->isModalOpen = true;
    }

    public function openEditModal() {
        $this->isEditModalOpen = true;
    }
    
    public function openDeleteModal() {
        $this->isDeleteModalOpen = true;
    }

    public function openProductInventarisModal() {
        $this->isProductInventarisModalOpen = true;
    }

    public function closeModal() {
        $this->isModalOpen = false;
        $this->isEditModalOpen = false;
        $this->isDeleteModalOpen = false;
    }

    public function resetCreateProductForm(){
        $this->productId = null;
        $this->productCode = null;
        $this->productName = null;
        $this->categoryId = null;
        $this->productDescription = null;
        $this->merk = null;
        $this->qty = null;
        $this->minimumStock = null;
    }

    public function createProduct() {
        $this->resetCreateProductForm();
        $this->dataCategory = ProductCategories::all();
        $this->openModal();
    }

    public function storeProduct() {
        $this->validate([
            'productName' => 'required|string',
            'categoryId' => 'required|string',
            'productDescription' => 'required|string',
            'merk' => 'required|string',
            'qty' => 'required|numeric',
            'minimumStock' => 'required|numeric',
        ]);

        Products::create([
            'productName' => $this->productName,
            'categoryId' => $this->categoryId,
            'productDescription' => $this->productDescription,
            'merk' => $this->merk,
            'qty' => $this->qty,
            'minimumStock' => $this->minimumStock,
        ]);

        session()->flash('message', 'Product has been created successfully.');

        $this->closeModal();
        $this->resetCreateProductForm();
    }

    public function editProduct($id)
    {
        $product = Products::findOrFail($id);
        $this->productId = $id;
        $this->productCode = $product->productCode;
        $this->productName = $product->productName;
        $this->categoryId = $product->categoryId;
        $this->dataCategory = ProductCategories::all();
        $this->productDescription = $product->productDescription;
        $this->merk = $product->merk;
        $this->qty = $product->qty;
        $this->minimumStock = $product->minimumStock;
        $this->openEditModal();
    }

    public function updateProduct() {
        $this->validate([
            'productName' => 'required|string',
            'categoryId' => 'required|numeric',
            'productDescription' => 'required|string',
            'merk' => 'required|string',
            'qty' => 'required|numeric',
            'minimumStock' => 'required|numeric',
        ]);

        $product = Products::findOrFail($this->productId);
        $product->update([
            'productName' => $this->productName,
            'categoryId' => $this->categoryId,
            'productDescription' => $this->productDescription,
            'merk' => $this->merk,
            'qty' => $this->qty,
            'minimumStock' => $this->minimumStock,
        ]);

        session()->flash('message', 'Product has been updated successfully.');

        $this->closeModal();
        $this->resetCreateProductForm();
    }

    public function confirmDeleteProduct($id)
    {
        $product = Products::findOrFail($id);
        $this->productId = $id;
        $this->productCode = $product->productCode;
        $this->productName = $product->productName;
        $this->openDeleteModal();
    }

    public function deleteProduct()
    {
        $product = Products::findOrFail($this->productId);
        $product->delete();
        session()->flash('message', 'Product has been deleted successfully.');
        $this->closeModal();
        $this->resetCreateProductForm();
    }

    public function viewProductInventaries($id)
    {
        $productInventaries = Products::with(['categories', 'inventories'])->findOrFail($id);
        $this->openProductInventarisModal();
    }
}
