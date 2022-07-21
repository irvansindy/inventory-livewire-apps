<?php

namespace App\Http\Livewire\Mutation;

use Livewire\Component;
use App\Models\Mutations;
use App\Models\MutationDetails;
use App\Models\MutationApprovals;
use App\Models\MutationFroms;
use App\Models\MutationTo;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductInventory;
use App\Models\Locations;
use Illuminate\Support\Facades\Gate;


class MutationData extends Component
{
    // data binding master mutations
    public $mutationId, $mutationNumber, $mutationDate, $mutationDescription, $userId, $inventoryId, $mutationStatus, $mutationApprovalId;

    // data binding mutation from
    public $mutationFromId, $mutationFromOfficeId;

    // data binding mutation to
    public $mutationToId, $mutationToOfficeId;

    // data binding product inventory
    public $productInventoryId, $productInventoryName;

    // data binding locations
    public $locationId, $locationName;

    // data binding global
    public $search;
    public $isModalMutationsOpen = 0;
    public $isModalCreateMutationsOpen = 0;
    public $isModalDetailMutationsOpen = 0;
    public $isModalApprovalMutationsOpen = 0;
    public $limitPerPage = 10;

    protected $queryString = ['search'=> ['except' => '']];
    protected $listeners = [
        'mutations' => 'mutationPostData'
    ];

    // data binding product inventory
    public $selectedInventory = [];
    public $allDataInventory = [];
    public $allDataMutation = [];

    // data binding approval
    public $signature, $commentApproval, $mutationApproval;

    public function mutationPostData()
    {
        $this->limitPerPage = $this->limitPerPage+6;
    }

    public function mount()
    {
        $this->allDataInventory = ProductInventory::where('productStatus' ,'=', 'AVAILABLE')->where('officeId', '=', 1)->get();
        // $this->signature = '';
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

    public function viewApprovalMutation($id)
    {
        Gate::authorize('admin');
        // get data approval
        $this->mutationApproval = MutationApprovals::with([
            'user',
            'mutation',
        ])
        ->where('userId', Auth::user()->id)
        ->where('mutationId', $id)->get();

        if ($this->mutationApproval->count() > 0) {
            // && $this->mutationApproval[0]->status == 'WAITING'
            // get data mutation detail
            $listMutationDetails = MutationDetails::with([
                'productInventory',
                'mutation',
            ])
            ->where('mutationId', $id)->get();

            // get data mutation from
            $MutationFroms = MutationFroms::where('mutationId', $id)->get();

            // get data mutation to
            $MutationTo = MutationTo::where('mutationId', '=', $id)->get();

            // data binding
            // mutation master
            $this->mutationId = $id;
            $this->mutationNumber = $this->mutationApproval[0]->mutation->mutationNumber;
            $this->mutationDate = $this->mutationApproval[0]->mutation->mutationDate;
            $this->mutationDescription = $this->mutationApproval[0]->mutation->mutationDescription;
            $this->userId = $this->mutationApproval[0]->mutation->user->name;
            $this->mutationStatus = $this->mutationApproval[0]->mutation->mutationStatus;

            $this->mutationApprovalId = $this->mutationApproval[0]->id;
            // mutation detail
            $this->allDataMutation = $listMutationDetails;

            // mutation from
            $this->mutationFromOfficeId = $MutationFroms[0]->office->officeName;

            // mutation to
            $this->mutationToOfficeId = $MutationTo[0]->office->officeName;

            $this->isModalApprovalMutationsOpen = true;
        } else {
            alert()->warning('WarningAlert','Mutation has been approved.');
        }
        
    }

    public function closeApproval()
    {
        $this->isModalApprovalMutationsOpen = false;
    }

    public function storeAndUpdateStaggingApprovalMutation()
    {
        Gate::authorize('admin');

        $this->validate([
            'commentApproval' => 'required|string',
            'signature' => 'required',
        ]);

        // check mutation master and mutation approval
        $checkMutationMaster = Mutations::findOrFail($this->mutationId);
        $checkMutationApproval = MutationApprovals::findOrFail($this->mutationApprovalId);
        // dd($checkMutationApproval);
        // store signature to local storage and database
        $folderPath = public_path('upload/images/signature/');

        $image_parts = explode(";base64,", $this->signature);

        $image_type_aux = explode("image/", $image_parts[0]);

        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);

        $fileToFolder = $folderPath . date('ymd-hi') . '.'.$image_type;

        $fileToDatabase = date('ymd-hi') . '.'.$image_type;

        // check if mutation master and mutation approval is same
        if ($checkMutationMaster->mutationStatus == 'PENDING') {
            if (Auth::user()->roles == 'ADMIN') {
                $checkMutationMaster->update([
                    'mutationStatus' => 'ON PROGRESS',
                ]);
    
                $checkMutationApproval->update([
                    'status' => 'FORWARD',
                    'comment' => $this->commentApproval,
                    'signature' => $fileToDatabase,
                ]);
    
                MutationApprovals::create([
                    'mutationId' => $this->mutationId,
                    'userId' => Auth::user()->parentUserId,
                    'status' => 'WAITING',
                    'comment' => NULL,
                    'signature' => NULL,
                ]);
            alert()->success('SuccessAlert','Mutation has been forward successfully.');
            
            $this-> closeApproval();
            }
        } elseif ($checkMutationMaster->mutationStatus == 'ON PROGRESS') {
            if (Auth::user()->roles == 'SUPERADMIN') {
                $checkMutationApproval->update([
                    'status' => 'APPROVE',
                    'comment' => $this->commentApproval,
                    'signature' => $fileToDatabase,
                ]);
                alert()->success('SuccessAlert','Mutation has been approved successfully.');
                
                $this-> closeApproval();
            }
        } else {
            alert()->warning('WarningAlert','Mutation has been error.');
        }

    }
}
