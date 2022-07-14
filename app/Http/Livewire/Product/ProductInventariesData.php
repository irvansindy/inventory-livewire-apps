<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\ProductInventory;
use App\Models\Mutations;
use App\Models\MutationFroms;
use App\Models\MutationTo;

use App\Models\Office;

use App\Models\InventoryPlacement;
use App\Models\InventoryPlacementDetails;
use Illuminate\Support\Facades\Auth;
use Alert;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductInventoryExport;
use PDF;

class ProductInventariesData extends Component
{
    // data master inventory
    public $allDataProductInventory, $inventoryId, $inventoryCode, $productId, $purchasingNumber, $registeredDate, $yearOfEntry, $yearOfUse, $serialNumber, $yearOfEnd, $sertificateNumber, $sertificateMaker, $productOrigin, $productPrice, $productDescription, $productStatus, $inventoryImageUrl;

    // data binding mutations
    public $mutationId, $mutationNumber, $mutationDate, $mutationDescription, $userIdMutation, $inventoryIdMutation, $mutationFromId, $mutationFromLocationId, $mutationToId, $mutationToLocationId, $locationInventoryIdNow, $locationInventoryNameNow;

    public $placementId;
    public $search;
    public $isModalOpen = 0;
    public $isEditModalOpen = 0;
    public $isDeleteModalOpen = 0;
    public $isMutationOpen = 0;
    public $limitPerPage = 10;

    protected $queryString = ['search'=> ['except' => '']];
    protected $listeners = [
        'productInventary' => 'productInventariesPostData'
    ];

    public $allDataOffice = [];

    public function mount()
    {
        $this->allDataOffice = Office::all();
    }

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
                ->orWhere('productPrice',  'LIKE', '%'.$this->search.'%')
                ->orWhere('merk',  'LIKE', '%'.$this->search.'%')
                ->orWhere('productStatus',  'LIKE', '%'.$this->search.'%');
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
    
    public function detailInventory($id) {
        $this->allDataProductInventory = ProductInventory::with(['products', 'user'])->findOrFail($id);
        // dd($this->allDataProductInventory);
        $this->inventoryCode = $this->allDataProductInventory->inventoryCode;
        $this->productId = $this->allDataProductInventory->products->productName;
        $this->purchasingNumber = $this->allDataProductInventory->purchasingNumber;
        $this->registeredDate = $this->allDataProductInventory->registeredDate;
        $this->yearOfEntry = $this->allDataProductInventory->yearOfEntry;
        $this->yearOfUse = $this->allDataProductInventory->yearOfUse;
        $this->serialNumber = $this->allDataProductInventory->serialNumber;
        $this->yearOfEnd = $this->allDataProductInventory->yearOfEnd;
        $this->sertificateNumber = $this->allDataProductInventory->sertificateNumber;
        $this->sertificateMaker = $this->allDataProductInventory->sertificateMaker;
        $this->productOrigin = $this->allDataProductInventory->supplier->supplierName;
        $this->productPrice = $this->allDataProductInventory->productPrice;
        $this->productDescription = $this->allDataProductInventory->productDescription;
        $this->productStatus = $this->allDataProductInventory->productStatus;
        $this->inventoryImageUrl = $this->allDataProductInventory->inventoryImageUrl;
        $this->openModal();
    }

    public function detailInventoryByStatus($id)
    {
        $checkInventoryDetail = ProductInventory::findOrFail($id);

        if($checkInventoryDetail->productStatus == 'PLACED') {
            $this->allDataProductInventory = ProductInventory::with([
                'products',
                'user',
            ]);
        } 
    }
    
    public function openMutation($id)
    {
        $this->inventoryId = $id;
        $inventory = InventoryPlacementDetails::with(['placement', 'productInventory'])
        ->where('productInventoryId', $id)->get();
        // dd($inventory);
        $this->placementId = $inventory[0]->placement->id;
        $this->inventoryCode = $inventory[0]->productInventory->inventoryCode;
        $this->inventoryIdMutation = $inventory[0]->productInventory->id;
        $this->locationInventoryIdNow = $inventory[0]->placement->location->id;
        $this->locationInventoryNameNow = $inventory[0]->placement->location->locationName;
        $this->isMutationOpen = true;
    }

    public function storeMutation()
    {
        $this->validate([
            'mutationDate' => 'required',
            'mutationDescription' => 'required',
        ]);

        $mutation = Mutations::create([
            'mutationDate' => $this->mutationDate,
            'mutationDescription' => $this->mutationDescription,
            'userId' => Auth::user()->id,
            'inventoryId' => $this->inventoryIdMutation,
        ]);
        
        MutationFroms::create([
            'mutationId' => $mutation->id,
            'locationId' => $this->locationInventoryIdNow,
        ]);

        MutationTo::create([
            'mutationId' => $mutation->id,
            'locationId' => $this->mutationToLocationId,
        ]);

        InventoryPlacement::findOrfail($this->placementId)->update([
            'placementType' => 'MUTATION'
        ]);

        $inventory = InventoryPlacementDetails::with(['placement', 'productInventory'])
        ->where('productInventoryId', $this->inventoryIdMutation)->get();

        $inventory[0]->placement->update([
            'locationId' => $this->mutationToLocationId,
        ]);

        alert()->success('SuccessAlert','Product inventory has been claimed successfully.');;

        $this->isMutationOpen = false;

    }
    
    public function closeMutation()
    {
        $this->isMutationOpen = false;
    }

    public function exportCSV()
    {
        // return Excel::download(new ProductInventoryExport, 'product-inventory.csv');
        return Excel::download(new ProductInventoryExport, 'product-inventory.xlsx');
    }

    public function exportPDF()
    {
        // $inventaries = ProductInventory::with(['products', 'user'])->get();
        $inventaries = ProductInventory::join(
            'products', 'products.id', '=', 'product_inventories.productId',
            )->join(
                'suppliers', 'suppliers.id', '=', 'product_inventories.productOrigin',
            )->join(
                'users', 'users.id', '=', 'product_inventories.sertificateMaker',
            )
            ->get([
            'product_inventories.inventoryCode', 
            'products.productName',
            'products.merk',
            'product_inventories.serialNumber', 
            'product_inventories.purchasingNumber', 
            'suppliers.supplierName',
            'product_inventories.productPrice', 
            'product_inventories.registeredDate', 
            'product_inventories.yearOfEntry', 
            'product_inventories.yearOfUse', 
            'product_inventories.productStatus', 
            'users.name'
        ]);

        $pdf = PDF::loadView('livewire.product.report-inventory', ['inventaries' => $inventaries])->setPaper('a4', 'portrait')->output();
        // return $pdf->download('product-inventory.pdf');
        return response()->streamDownload(fn() => print($pdf), 'inventory.pdf');
    }
}
