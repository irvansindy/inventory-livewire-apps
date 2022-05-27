<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\ProductInventory;

class ProductInventariesData extends Component
{
    public $allDataProductInventory, $inventoryId, $inventoryCode, $productId, $purchasingNumber, $registeredDate, $yearOfEntry, $yearOfUse, $serialNumber, $yearOfEnd, $sertificateNumber, $sertificateMaker, $productOrigin, $productPrice, $productDescription, $productStatus;

    public $search;
    public $isModalOpen = 0;
    public $isEditModalOpen = 0;
    public $isDeleteModalOpen = 0;
    public $limitPerPage = 10;

    protected $queryString = ['search'=> ['except' => '']];
    protected $listeners = [
        'productInventary' => 'productInventariesPostData'
    ];

    public function productInventariesPostData() {
        $this->limitPerPage = $this->limitPerPage + 1;  
    }

    public function render()
    {
        $inventaries = ProductInventory::latest()->paginate($this->limitPerPage);

        if($this->search !== null) {
            $inventaries = ProductInventory::with('products')->whereHas('products', function($query) {
                $query->where('productName', 'LIKE', '%'.$this->search.'%')
                ->orWhere('productCode',  'LIKE', '%'.$this->search.'%')
                ->orWhere('productDescription',  'LIKE', '%'.$this->search.'%')
                ->orWhere('merk',  'LIKE', '%'.$this->search.'%')
                ->orWhere('qty',  'LIKE', '%'.$this->search.'%')
                ->orWhere('minimumStock',  'LIKE', '%'.$this->search.'%');
            })->paginate($this->limitPerPage);
        }

        return view('livewire.product.product-inventaries-data', ['inventaries' => $inventaries]);
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

    public function closeModal() {
        $this->isModalOpen = false;
        $this->isEditModalOpen = false;
        $this->isDeleteModalOpen = false;
    }

    public function resetCreateInventoryForm() {
        $this->inventoryCode = null;
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

    
}
