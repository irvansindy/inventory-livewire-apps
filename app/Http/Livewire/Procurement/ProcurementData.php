<?php

namespace App\Http\Livewire\Procurement;

use Livewire\Component;
use App\Models\Users;
use App\Models\Suppliers;
use App\Models\Products;
use App\Models\InventoryProcurement;
use App\Models\InventoryProcurementDetails;

class ProcurementData extends Component
{
    // table procurement
    public $procurementCode, $userId, $supplierId, $procurementTypeId, $procurementDescription, $procurementDate, $totalPrice, $status;
    // table procurement details
    public $procurementId, $productId, $description, $quantity, $unitPrice;

    public $search;
    public $isModalOpen = 0;
    public $limitPerPage = 10;
    protected $queryString = ['search'=> ['except' => '']];
    protected $listeners = [
        'procurement' => 'procurementPostData'
    ];

    public function procurementPostData() {
        $this->limitPerPage = $this->limitPerPage+6;
    }

    public function openModal() {
        $this->isModalOpen = true;
    }

    public function closeModal() {
        $this->isModalOpen = false;
    }

    public function render()
    {
        // $procurements = InventoryProcurement::latest()->paginate($this->limitPerPage);
        $procurements = InventoryProcurement::with('supplier')
        ->with('procurementType')
        ->with('user')
        ->latest()
        ->paginate($this->limitPerPage);
        
        // dd($procurements);

        if($this->search !== NULL) {
            // $procurements = InventoryProcurement::where('procurementCode', 'like', '%'.$this->search.'%')
            //     ->orWhere('userId', 'like', '%'.$this->search.'%')
            //     ->orWhere('supplierID', 'like', '%'.$this->search.'%')
            //     ->orWhere('procurementTypeId', 'like', '%'.$this->search.'%')
            //     ->orWhere('totalPrice', 'like', '%'.$this->search.'%')
            //     ->orWhere('status', 'like', '%'.$this->search.'%')
            //     ->paginate($this->limitPerPage);

            // $procurements = InventoryProcurement::with([
            //     'user',
            //     'products',
            //     'supplier',
            //     'procurementType',
            //     // 'procurementDetails'
            // ])->whereHas('user', function($query) {
            //     $query->where('username', 'like', '%'.$this->search.'%');
            // })->orWhereHas('supplier', function($query) {
            //     $query->where('supplierName', 'like', '%'.$this->search.'%');
            // })->orWhereHas('procurementType', function($query) {
            //     $query->where('procurementTypeName', 'like', '%'.$this->search.'%');
            // })->orWhere('totalPrice', 'like', '%'.$this->search.'%')
            // ->orWhere('status', 'like', '%'.$this->search.'%')
            // ->orWhere('procurementCode', 'like', '%'.$this->search.'%');

            // $procurements = $procurements->paginate($this->limitPerPage);
        }

        // $this->emit('procurementPostData');

        return view('livewire.procurement.procurement-data', [
            'procurements' => $procurements
        ]);
    }

    public function addProcurement() {
        // return view('livewire.procurement.form-procurement-data');
        $this->openModal();
    }
}
