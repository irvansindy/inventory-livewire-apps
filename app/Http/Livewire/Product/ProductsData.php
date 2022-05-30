<?php

namespace App\Http\Livewire\Product;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Products;
use App\Models\ProductCategories;
use App\Models\ProductInventory;

class ProductsData extends Component
{
    use WithFileUploads;

    public $allDataProduct, $productId, $productCode, $productName, $categoryId, $productDescription, $merk, $qty, $minimumStock;

    public $allDataProductInventory, $inventoryId, $inventoryCode, $purchasingNumber, $registeredDate, $yearOfEntry, $yearOfUse, $serialNumber, $yearOfEnd, $sertificateNumber, $sertificateMaker, $productOrigin, $productPrice, $productDescription2, $productStatus, $inventoryImageUrl;
    
    public $search;
    public $dataCategory;
    public $isModalOpen = 0;
    public $isEditModalOpen = 0;
    public $isDeleteModalOpen = 0;
    public $isProductInventarisModalOpen = 0;
    public $isCreateProductInventarisModalOpen = 0;
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
    
    public function openCreateProductInventarisModal() {
        $this->isCreateProductInventarisModalOpen = true;
    }

    public function closeModal() {
        $this->isModalOpen = false;
        $this->isEditModalOpen = false;
        $this->isDeleteModalOpen = false;
        $this->isProductInventarisModalOpen = false;
    }

    public function closeFromInventory() {
        $this->isCreateProductInventarisModalOpen = false;
        $this->openProductInventarisModal();
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

    public function resetCreateInventoryForm() {
        // $this->inventoryCode = null;
        // $this->productId = null;
        $this->purchasingNumber = null;
        $this->registeredDate = null;
        $this->yearOfEntry = null;
        $this->yearOfUse = null;
        $this->serialNumber = null;
        $this->yearOfEnd = null;
        $this->sertificateNumber = null;
        $this->sertificateMaker = null;
        $this->productOrigin = null;
        $this->productPrice = null;
        $this->productDescription = null;
        $this->productStatus = null;
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
        // dd($productInventaries);
        $this->productId = $id;
        $this->productCode = $productInventaries->productCode;
        $this->productName = $productInventaries->productName;
        $this->categoryId = $productInventaries->categories->categoryName;
        $this->productDescription = $productInventaries->productDescription;
        $this->merk = $productInventaries->merk;
        $this->qty = $productInventaries->qty;
        $this->minimumStock = $productInventaries->minimumStock;
        $this->productInventory = array($productInventaries->inventories);
        // dd($this->productInventory);
        $this->openProductInventarisModal();
    }

    public function createInventory($id) {
        $product = Products::findOrFail($id);
        $this->productId = $id;
        $this->closeModal();
        $this->openCreateProductInventarisModal();
    }

    public function storeInventory() {
        $this->validate([
            'productId' => 'required',
            'purchasingNumber' => 'required|string',
            'registeredDate' => 'required|date',
            'yearOfEntry' => 'required|date',
            'yearOfUse' => 'required|date',
            'serialNumber' => 'required|string',
            'yearOfEnd' => 'required|date',
            'sertificateNumber' => 'required|string',
            // 'sertificateMaker' => 'required|string',
            'productOrigin' => 'required|string',
            'productPrice' => 'required',
            'productDescription' => 'required|string',
            // 'inventoryImageUrl' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);
        // $product = Products::findOrFail($this->productId);

        // $imageName = $this->inventoryImageUrl->extension();
        // $finalImage = Image::make($imageName)->encode('webp',90)
        // ->resize(300, 300)
        // ->store(public_path('uploads/'  .  $imageName . '.webp'));
        // ->store('images', 'public');
        
        // $imageName = md5($this->inventoryImageUrl . microtime()).'.'.$this->inventoryImageUrl->extension();
        // $imagewebp = Webp::make($imageName);
        // $imagewebp->save(public_path('imageInventory'));

        ProductInventory::create([
            'productId' => $this->productId,
            'purchasingNumber' => $this->purchasingNumber,
            'registeredDate' => $this->registeredDate,
            'yearOfEntry' => $this->yearOfEntry,
            'yearOfUse' => $this->yearOfUse,
            'serialNumber' => $this->serialNumber,
            'yearOfEnd' => $this->yearOfEnd,
            'sertificateNumber' => $this->sertificateNumber,
            // 'sertificateMaker' => $this->sertificateMaker,
            'sertificateMaker' => Auth::user()->id,
            'productOrigin' => $this->productOrigin,
            'productPrice' => $this->productPrice,
            'productDescription' => $this->productDescription,
            // 'inventoryImageUrl' => $this->inventoryImageUrl,
            // 'inventoryImageUrl' => $imageName,
        ]);

        session()->flash('message', 'Product Inventory has been created successfully.');

        $this->closeFromInventory();
        $this->resetCreateInventoryForm();
    }
}
