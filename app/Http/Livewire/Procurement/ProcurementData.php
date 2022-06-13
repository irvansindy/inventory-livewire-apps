<?php

namespace App\Http\Livewire\Procurement;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Users;
use App\Models\Suppliers;
use App\Models\Products;
use App\Models\InventoryProcurement;
use App\Models\InventoryProcurementDetails;
use App\Models\ProcurementType;

class ProcurementData extends Component
{
    // table procurement
    public $procurementCode, $userId, $supplierId, $procurementTypeId, $procurementDescription, $procurementDate, $totalPrice, $status;
    // table procurement details
    public $procurementId, $productId, $description, $unitPrice, $procurementDetails;

    // data supplier and procurement type
    public $dataSupplier, $dataProcurementType;

    // data details
    public $productName, $supplierName, $procurementTypeName, $userName;

    // for view procurement
    public $search;
    public $isModalOpen = 0;
    public $limitPerPage = 10;
    protected $queryString = ['search'=> ['except' => '']];
    protected $listeners = [
        'procurement' => 'procurementPostData'
    ];

    public $allProducts = [];
    public $orderProcurements = [];

    public function mount() {
        $this->allProducts = Products::all();
        $this->orderProcurements = [
            [
                'productId' => '',
                'description' => '',
                'unitPrice' => 0,
                'quantity' => 1,
            ]
        ];
    }

    // for view procurement
    public $isDetailProcurement = 0;

    public function addProductProcurement()
    {
        $this->orderProcurements[] = [
            [
                'productId' => '',
                'description' => '',
                'unitPrice' => 0,
                'quantity' => 1,
            ]
        ];
    }

    public function removeProductProcurement($index)
    {   
        unset($this->orderProcurements[$index]);
        array_values($this->orderProcurements);
    }

    public function procurementPostData() {
        $this->limitPerPage = $this->limitPerPage+6;
    }

    public function openModal() {
        $this->isModalOpen = true;
    }

    public function closeModal() {
        $this->isModalOpen = false;
        $this->isDetailProcurement = false;
        $this->resetProcurementForm();
    }

    public function openDetailModal()
    {
        $this->isDetailProcurement = true;
    }

    public function resetProcurementForm()
    {
        $this->procurementCode = '';
        $this->userId = '';
        $this->supplierId = '';
        $this->procurementTypeId = '';
        $this->procurementDescription = '';
        $this->procurementDate = '';
        $this->totalPrice = '';
        $this->status = '';
        $this->procurementId = '';
        $this->productId = '';
        $this->description = '';
        $this->unitPrice = '';
        $this->procurementDetails = '';
        $this->orderProcurements = [
            [
                'productId' => '',
                'description' => '',
                'unitPrice' => 0,
                'quantity' => 1,
            ]
        ];
    }

    public function addProcurement() 
    {
        $this->dataSupplier = Suppliers::all();
        $this->dataProcurementType = ProcurementType::all();
        $this->openModal();
    }

    public function storeProcurement()
    {
        // dd($this->allProducts);
        $this->validate([
            'supplierId' => 'required',
            'procurementTypeId' => 'required',
            'procurementDescription' => 'required',
            'procurementDate' => 'required',
            'productId.*' => 'required',
            'description.*' => 'required',
            'unitPrice.*' => 'required',
            'orderProcurements.*.productId' => 'required',
            'orderProcurements.*.description' => 'required',
            'orderProcurements.*.unitPrice' => 'required',
        ]);
        
        $this->totalPrice = $this->orderProcurements[0]['unitPrice'] * $this->orderProcurements[0]['quantity'];

        $procurementMaster = InventoryProcurement::create([
            'userId' => Auth::user()->id,
            'supplierId' => $this->supplierId,
            'procurementTypeId' => $this->procurementTypeId,
            'procurementDescription' => $this->procurementDescription,
            'procurementDate' => $this->procurementDate,
            'totalPrice' => $this->totalPrice,
            'status' => 0,
        ]);

        foreach ($this->orderProcurements as $procurementDetail => $value)
        {
            InventoryProcurementDetails::create([
                'procurementId' => $procurementMaster->id,
                'productId' => $value['productId'],
                'description' => $value['description'],
                'unitPrice' => $value['unitPrice'],
                'quantity' => $value['quantity'],
            ]);
        }

        session()->flash('message', 'Procurement has been created successfully.');

        $this->closeModal();
        // $this->resetProcurementForm();
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
            $procurements = InventoryProcurement::with([
                'user',
                'products',
                'supplier',
                'procurementType',
            ])->whereHas('user', function($query) {
                $query->where('username', 'like', '%'.$this->search.'%');
            })->orWhereHas('supplier', function($query) {
                $query->where('supplierName', 'like', '%'.$this->search.'%');
            })->orWhereHas('procurementType', function($query) {
                $query->where('procurementTypeName', 'like', '%'.$this->search.'%');
            })->orWhere('totalPrice', 'like', '%'.$this->search.'%')
            ->orWhere('status', 'like', '%'.$this->search.'%')
            ->orWhere('procurementCode', 'like', '%'.$this->search.'%');

            $procurements = $procurements->paginate($this->limitPerPage);
        }

        $this->emit('procurementPostData');

        return view('livewire.procurement.procurement-data', [
            'procurements' => $procurements
        ]);
    }

    public function detailProcurement($id)
    {
        $procurementDetails = InventoryProcurement::with([
            'user',
            'products',
            'supplier',
            'procurementType',
            'procurementDetails'
        ])->findOrFail($id);

        $this->procurementId = $procurementDetails->id;
        $this->procurementCode = $procurementDetails->procurementCode;
        $this->userName = $procurementDetails->user->name;
        $this->supplierName = $procurementDetails->supplier->supplierName;
        $this->procurementTypeName = $procurementDetails->procurementType->procurementTypeName;
        $this->procurementDescription = $procurementDetails->procurementDescription;
        $this->procurementDate = $procurementDetails->procurementDate;
        $this->totalPrice = $procurementDetails->totalPrice;
        $this->status = $procurementDetails->status;

        // join product and procurement detail
        $this->procurementDetails = $procurementDetails->procurementDetails->join('products', 'products.id', '=', $procurementDetails->procurementDetails.'productId');

        $this->procurementDetails = [$procurementDetails->procurementDetails];
        $this->openDetailModal();
    }
}
