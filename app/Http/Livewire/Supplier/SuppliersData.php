<?php

namespace App\Http\Livewire\Supplier;

use Livewire\Component;
use App\Models\Suppliers;


class SuppliersData extends Component
{
    public $supplierId, $supplierName, $supplierAddress, $supplierNumber;
    public $search;
    public $isModalOpen = 0;
    public $isEditModalOpen = 0;
    public $isDeleteModalOpen = 0;
    public $limitPerPage = 10;
    protected $queryString = ['search'=> ['except' => '']];
    protected $listeners = [
        'suppliers' => 'supplierPostData'
    ];

    public function supplierPostData() {
        $this->limitPerPage = $this->limitPerPage+6;
    }

    public function render()
    {
        $suppliers = Suppliers::where('supplierName', 'like', '%'.$this->search.'%')
                ->orWhere('supplierAddress', 'like', '%'.$this->search.'%')
                ->orWhere('supplierNumber', 'like', '%'.$this->search.'%')
                ->paginate($this->limitPerPage);
        
        $this->emit('supplierPostData');

        return view('livewire.supplier.suppliers-data', ['suppliers' => $suppliers]);

    }

    public function openModal () {
        $this->isModalOpen = true;
    }
    
    public function openEditModal() {
        $this->isEditModalOpen = true;
    }

    public function openDeleteModal() {
        $this->isDeleteModalOpen = true;
    }

    public function closeModal () {
        $this->isModalOpen = false;
        $this->isEditModalOpen = false;
        $this->isDeleteModalOpen = false;
    }

    public function resetSupplierForm() {
        $this->supplierId = null;
        $this->supplierName = null;
        $this->supplierAddress = null;
        $this->supplierNumber = null;
    }

    public function createSupplier() {
        $this->resetSupplierForm();
        $this->openModal();
    }

    public function storeSupplier() 
    {
        $this->validate([
            'supplierName' => 'required|string|min:3|max:255',
            'supplierAddress' => 'required|string|min:3|max:255',
            'supplierNumber' => 'required|numeric|max:13',
        ]);

        Suppliers::create([
            'supplierName' => $this->supplierName,
            'supplierAddress' => $this->supplierAddress,
            'supplierNumber' => $this->supplierNumber,
        ]);

        session()->flash('message', 'Supplier has been created successfully.');

        $this->closeModal();
        $this->resetSupplierForm();
    }

    public function editSupplier($id) 
    {
        $supplier = Suppliers::findOrFail($id);
        $this->supplierId = $id;
        $this->supplierName = $supplier->supplierName;
        $this->supplierAddress = $supplier->supplierAddress;
        $this->supplierNumber = $supplier->supplierNumber;
        $this->openEditModal();
    }

    public function updateSupplier() 
    {
        $this->validate([
            'supplierName' => 'required|string|min:3|max:255',
            'supplierAddress' => 'required|string|min:3|max:255',
            'supplierNumber' => 'required|numeric|max:13',
        ]);

        $supplier = Suppliers::findOrFail($this->supplierId);
        $supplier->update([
            'supplierName' => $this->supplierName,
            'supplierAddress' => $this->supplierAddress,
            'supplierNumber' => $this->supplierNumber,
        ]);

        session()->flash('message', 'Supplier has been updated successfully.');

        $this->closeModal();
        $this->resetSupplierForm();
    }

    public function confirmDeleteSupplier($id) 
    {
        $supplier = Suppliers::findOrFail($id);
        $this->supplierId = $id;
        $this->supplierName = $supplier->supplierName;
        $this->supplierAddress = $supplier->supplierAddress;
        $this->supplierNumber = $supplier->supplierNumber;
        $this->openDeleteModal();
    }

    public function destroySupplier() 
    {
        $supplier = Suppliers::findOrFail($this->supplierId);
        $supplier->delete();

        session()->flash('message', 'Supplier has been deleted successfully.');

        $this->closeModal();
        $this->resetSupplierForm();
    }

}
