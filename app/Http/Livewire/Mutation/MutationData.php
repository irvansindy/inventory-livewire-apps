<?php

namespace App\Http\Livewire\Mutation;

use Livewire\Component;
use App\Models\Mutations;
use App\Models\MutationFroms;
use App\Models\MutationTo;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductInventory;
use App\Models\Locations;


class MutationData extends Component
{
    // data binding master mutations
    public $mutationId, $mutationNumber, $mutationDate, $mutationDescription, $userId, $inventoryId;

    // data binding mutation from
    public $mutationFromId, $mutationFromLocationId;

    // data binding mutation to
    public $mutationToId, $mutationToLocationId;

    // data binding product inventory
    public $productInventoryId, $productInventoryName;

    // data binding locations
    public $locationId, $locationName;

    // data binding product inventory
    public $productInventoryIdArray = [];
    public $selected;

    // data binding global
    public $search;
    public $isModalMutationsOpen = 0;
    public $isModalCreateMutationsOpen = 0;
    public $isModalEditMutationsOpen = 0;
    public $limitPerPage = 10;

    protected $queryString = ['search'=> ['except' => '']];
    protected $listeners = [
        'mutations' => 'mutationPostData'
    ];

    // public $allDataMutations = [];
    public $allDataInventory = [];

    public function mutationPostData()
    {
        $this->limitPerPage = $this->limitPerPage+6;
    }

    public function mount()
    {
        $this->allDataInventory = ProductInventory::where('productStatus' ,'!=', 'AVAILABLE')->get();
        // dd($this->allDataInventory);
    }
    
    public function closeModal()
    {
        $this->isModalMutationsOpen = false;
    }

    public function render()
    {
        $mutations = Mutations::with(['user', 'inventory'])->latest()->paginate($this->limitPerPage);

        if($this->search !== NULL) {
            $mutations = Mutations::with(['user', 'inventory'])
            ->where('user', function($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhere('inventory', function($query) {
                $query->where('inventoryCode', 'like', '%' . $this->search . '%');
            })
            ->orWhere('mutationNumber', 'LIKE', '%'.$this->search.'%')
            ->orWhere('mutationDate', 'LIKE', '%'.$this->search.'%')
            ->latest()
            ->paginate($this->limitPerPage);
        }
        $this->emit('mutationPostData');
        return view('livewire.mutation.mutation-data', ['mutations' => $mutations]);
    }

    public function formCreateMutation()
    {

        $this->isModalMutationsOpen = true;
    }
}
