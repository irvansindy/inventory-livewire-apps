<?php

namespace App\Http\Livewire\Placement;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\InventoryPlacement;
use App\Models\InventoryPlacementDetails;
use App\Models\ProductInventory;
use App\Models\Locations;

class PlacementData extends Component
{
    // public $placement;

    // data master placement
    public $getInventoryId, $placementNumber, $placementDate, $userId, $locationId, $placementDescription, $placementType;

    // data detail placement
    public $placementId, $productInventaryId, $status, $inventoryCode;

    // data product inventory
    public $allDataInventory = [];

    // data location
    public $allDataLocation = [];

    //data binding system
    public $search;
    public $isModalPlacementOpen = 0;
    public $isformCreateModalOpen = 0; 
    public $isDetailPlacementOpen = 0;
    public $isReturnPlacementOpen = 0;
    public $limitPerPage = 10;
    protected $queryString = ['search'=> ['except' => '']];
    protected $listeners = [
        'inventoryPlacement' => 'placementPostData'
    ];

    public function placementPostData()
    {
        $this->limitPerPage = $this->limitPerPage+6;
    }

    // public function mount()
    // {
    //     $this->allDataInventory = ProductInventory::with(['products'])->where('productStatus', '=', 'AVAILABLE')->get();
    //     $this->allDataLocation = Locations::all();
    // }

    public function openCreatePlacementModal() 
    {
        $this->isModalPlacementOpen = true;
    }

    public function closeModal()
    {
        $this->isModalPlacementOpen = false;
    }

    public function createPlacement()
    {
        $this->allDataInventory = ProductInventory::with(['products'])->where('productStatus', '=', 'AVAILABLE')->get();
        $this->allDataLocation = Locations::all();
        $this->openCreatePlacementModal();
    }

    public function openFormCreateModal()
    {
        $this->isformCreateModalOpen = true;
    }

    public function closeFormCreateModal()
    {
        $this->isformCreateModalOpen = false;
    }

    public function render()
    {
        $placements = InventoryPlacement::with(['user', 'location'])
        ->latest()
        ->paginate($this->limitPerPage);

        if($this->search !== NULL) {
            $placements = InventoryPlacement::with(['user', 'location'])
            ->whereHas('user', function($query) {
                $query->where('name', 'like', '%'.$this->search.'%');
            })->orWhereHas('location', function($query) {
                $query->where('locationName', 'like', '%'.$this->search.'%');
            })
            ->orWhere('placementNumber', 'like', '%'.$this->search.'%')
            ->orWhere('placementDate', 'like', '%'.$this->search.'%')
            ->orWhere('placementType', 'like', '%'.$this->search.'%')
            ->paginate($this->limitPerPage);
        }
        // $this->status = $detailPlacement->placementDetails[0]->status;

        return view('livewire.placement.placement-data', ['placements' => $placements]);
    }

    public function resetFormPlacement()
    {
        // $this->getInventoryId = NULL;
        $this->placementDate = NULL;
        // $this->userId = NULL;
        $this->locationId = NULL;
        $this->placementDescription = NULL;
        $this->placementType = NULL;
    }

    public function formCreatePlacement($id)
    {
        $inventory = ProductInventory::findOrFail($id);
        $this->getInventoryId = $inventory->id;
        // dd($this->getInventoryId);
        $this->closeModal();
        $this->openFormCreateModal();
    }

    public function closeFormPlacement()
    {
        $this->closeFormCreateModal();
        $this->createPlacement();
    }

    public function storePlacementInventory()
    {
        $this->validate([
            'placementDate' => 'required',
            'locationId' => 'required',
            'placementDescription' => 'required',
            'placementType' => 'required',
        ]);

        $placement = InventoryPlacement::create([
            'placementDate' => $this->placementDate,
            'userId' => Auth::user()->id,
            'locationId' => $this->locationId,
            'placementDescription' => $this->placementDescription,
            'placementType' => $this->placementType,
        ]);

        ProductInventory::findOrFail($this->getInventoryId)->update([
            'productStatus' => 'PLACED',
        ]);
        
        InventoryPlacementDetails::create([
            'placementId' => $placement->id,
            'productInventoryId' => $this->getInventoryId,
        ]);
        // }

        

        session()->flash('message', 'Placement has been created successfully.');

        $this->closeFormPlacement();
        $this->closeModal();
        // $this->resetFormPlacement();
    }

    public function detailPlacement($id)
    {
        $detailPlacement = InventoryPlacement::with([
            'placementDetails',
            'user',
            'location'
        ])->findOrFail($id);

        // dd($detailPlacement);
        $this->placementNumber = $detailPlacement->placementNumber;
        $this->placementDate = $detailPlacement->placementDate;
        $this->userId = $detailPlacement->user->name;
        $this->locationId = $detailPlacement->location->locationName;
        $this->placementDescription = $detailPlacement->placementDescription;
        $this->placementType = $detailPlacement->placementType;
        $this->getInventoryId = $detailPlacement->placementDetails[0]->productInventory->inventoryCode;
        $this->status = $detailPlacement->placementDetails[0]->status;
        $this->isDetailPlacementOpen = true;
    }

    public function closeDetail()
    {
        $this->isDetailPlacementOpen = false;
    }
    
    public function closeReturn()
    {
        $this->isReturnPlacementOpen = false;
    }

    public function confirmReturn($id)
    {
        $placement = InventoryPlacement::with(['placementDetails'])->findOrFail($id);
        $this->placementId = $placement->id;
        $this->getInventoryId = $placement->placementDetails[0]->productInventory->id;
        $this->inventoryCode = $placement->placementDetails[0]->productInventory->inventoryCode;
        $this->isReturnPlacementOpen = true;
    }

    public function returnPlacementInventory()
    {
        InventoryPlacementDetails::where('productInventoryId', '=', $this->getInventoryId)
        ->where('placementId', '=', $this->placementId)
        ->update([
            'status' => 'INACTIVE',
        ]);

        ProductInventory::findOrFail($this->getInventoryId)->update([
            'productStatus' => 'AVAILABLE',
        ]);

        $this->isReturnPlacementOpen = false;

        session()->flash('message', 'Placement has been returned successfully.');
    }

}
