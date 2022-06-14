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
    public $getInventoryId, $placementDate, $userId, $locationId, $placementDescription, $placementType;

    // data detail placement
    public $placementId, $productInventaryId, $status;

    // data product inventory
    public $allDataInventory = [];

    // data location
    public $allDataLocation = [];

    //data binding system
    public $search;
    public $isModalPlacementOpen = 0;
    public $isformCreateModalOpen = 0; 
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
            })->orWhere('placementName', 'like', '%'.$this->search.'%')
            ->orWhere('placementDate', 'like', '%'.$this->search.'%')
            ->orWhere('placementType', 'like', '%'.$this->search.'%')
            ->paginate($this->limitPerPage);
        }

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
        // dd($placement);
        // foreach ($placement as $items) {
        //     dd($placement);
        ProductInventory::findOrFail($this->getInventoryId)->update([
            'productStatus' => 'PLACED',
        ]);
        
        InventoryPlacementDetails::create([
            'placementId' => $placement->id,
            'productInventoryId' => $this->getInventoryId,
            // 'status' => 'PLACED',
            // $this->placementId = $placement->id,
            // $this->productInventaryId = $this->getInventoryId,
            // $this->status = 'Active',
        ]);
        // }

        

        session()->flash('message', 'Placement has been created successfully.');

        $this->closeFormPlacement();
        $this->closeModal();
        // $this->resetFormPlacement();
    }

}
