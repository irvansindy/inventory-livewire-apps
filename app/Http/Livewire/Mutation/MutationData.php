<?php

namespace App\Http\Livewire\Mutation;

use Livewire\Component;
use App\Models\Mutations;
use App\Models\MutationDetails;
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

    // data binding global
    public $search;
    public $isModalMutationsOpen = 0;
    public $isModalCreateMutationsOpen = 0;
    public $isModalDetailMutationsOpen = 0;
    public $isModalEditMutationsOpen = 0;
    public $limitPerPage = 10;

    protected $queryString = ['search'=> ['except' => '']];
    protected $listeners = [
        'mutations' => 'mutationPostData'
    ];

    // data binding product inventory
    public $selectedInventory = [];
    public $allDataInventory = [];
    public $allDataMutation = [];

    public function mutationPostData()
    {
        $this->limitPerPage = $this->limitPerPage+6;
    }

    public function mount()
    {
        $this->allDataInventory = ProductInventory::where('productStatus' ,'=', 'AVAILABLE')->where('officeId', '=', 1)->get();
        // dd($this->allDataInventory);
    }
    
    public function closeModal()
    {
        $this->isModalMutationsOpen = false;
    }

    public function render()
    {
        $mutations = Mutations::with(['user'])->latest()->paginate($this->limitPerPage);

        if($this->search !== NULL) {
            $mutations = Mutations::with(['user'])
            ->whereHas('user', function($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhere('mutationNumber', 'LIKE', '%'.$this->search.'%')
            ->orWhere('mutationDate', 'LIKE', '%'.$this->search.'%')
            ->orWhere('mutationStatus', 'LIKE', '%'.$this->search.'%')
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

    public function storeMutation()
    {
        $this->validate([
            'mutationDate' => 'required',
            'mutationDescription' => 'required',
            'selectedInventory' => 'required'
        ]);

        $mutation = Mutations::create([
            'mutationDate' => $this->mutationDate,
            'mutationDescription' => $this->mutationDescription,
            'userId' => Auth::user()->id,
            'mutationStatus' => 'PENDING'
        ]);

        foreach ($this->selectedInventory as $key => $value) {
            MutationDetails::create([
                'mutationId' => $mutation->id,
                'productInventoryId' => $value,
            ]);
        }

        MutationFroms::create([
            'mutationId' => $mutation->id,
            'officeId' => 1,
        ]);

        MutationTo::create([
            'mutationId' => $mutation->id,
            'officeId' => Auth::user()->officeId,
        ]);

        $this->emit('mutationPostData');
        alert()->success('SuccessAlert','Product mutation has been created successfully.');
        $this->isModalMutationsOpen = false;
        
    }

    public function detailMutation($id)
    {
        $Mutations = Mutations::findOrFail($id);
        $MutationDetails = MutationDetails::where('mutationId', $id)->get();
        $MutationFroms = MutationFroms::where('mutationId', $id)->get();
        // with(['office'])->
        $MutationTo = MutationTo::where('mutationId', '=', $id)->get();

        // dd([$MutationFroms[0]->office->officeName]);

        $this->allDataMutation = [
            $Mutations,
            $MutationDetails,
            $MutationFroms,
            $MutationTo,
        ];

        // dd($this->allDataMutation[2]);

        // $this->mutationId = $id;
        $this->isModalDetailMutationsOpen = true;
    }

    public function closeDetail()
    {
        $this->isModalDetailMutationsOpen = false;
    }
}
