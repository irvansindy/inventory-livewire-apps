<?php

namespace App\Http\Livewire\Loan;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\InventoryLoan;
use App\Models\InventoryLoanDetails;
use App\Models\ProductInventory;
use App\Models\Locations;

class LoanData extends Component
{
    // master loans
    public $getInventoryId, $loanCode, $loanStartDate, $loanEndDate, $loanerUserId, $officerUserId, $locationId, $loanDescription, $status;

    // detail loans
    public $loanId, $productInventaryId;

    // data binding system
    public $search;
    public $isModalLoanOpen = 0;
    public $isformCreateModalOpen = 0;
    public $isDetailLoanOpen = 0;
    public $isReturnLoanOpen = 0;
    public $limitPerPage = 10;
    protected $queryString = ['search'=> ['except' => '']];
    protected $listeners = [
        'inventoryLoan' => 'loanPostData'
    ];

    public $allDataInventory = [];
    public $allDataLocation = [];

    public function loanPostData()
    {
        $this->limitPerPage = $this->limitPerPage+6;
    }

    public function mount()
    {
        $this->allDataInventory = ProductInventory::with(['products'])->where('productStatus', '=', 'AVAILABLE')->get();
        $this->allDataLocation = Locations::all();
    }

    public function resetLoan()
    {
        
    }

    public function openModal()
    {
        $this->isModalLoanOpen = true;
    }
    
    public function closeModal()
    {
        $this->isModalLoanOpen = false;
    }

    public function openFormLoanModal()
    {
        $this->isformCreateModalOpen = true;
    }
    
    public function closeFormLoanModal()
    {
        $this->isformCreateModalOpen = false;
        $this->openModal();
    }

    public function createModalLoan()
    {
        $this->openModal();
    }

    public function formCreateLoan($id)
    {
        $inventory = ProductInventory::findOrFail($id);
        $this->getInventoryId = $inventory->id;
        $this->closeModal();
        $this->openFormLoanModal();
    }

    public function storeLoan()
    {
        $this->validate([
            'loanStartDate' => 'required',
            'loanEndDate' => 'required',
            'locationId' => 'required',
            'loanDescription' => 'required',
        ]);

        $loan = InventoryLoan::create([
            'loanStartDate' => $this->loanStartDate,
            'loanEndDate' => $this->loanEndDate,
            'officerUserId' => $this->locationId,
            'loanDescription' => $this->loanDescription,
            'loanerUserId' => Auth::user()->id,
            'status' => 'LOANED',
        ]);

        InventoryLoanDetails::create([
            'loanId' => $loan->id,
            'productInventaryId' => $this->getInventoryId,
        ]);

        ProductInventory::findOrFail($this->getInventoryId)->update([
            'productStatus' => 'LOANED',
        ]);

        session()->flash('message', 'Loan has been created successfully.');

        $this->closeFormLoanModal();
    }

    public function render()
    {
        $loans = InventoryLoan::with(['user', 'location'])->latest()->paginate($this->limitPerPage);

        if($this->search !== NULL) {
            $loans = InventoryLoan::with(['user', 'location'])
            ->whereHas('user', function($query) {
                $query->where('name', 'like', '%'.$this->search.'%');
            })->orWhereHas('location', function($query) {
                $query->where('locationName', 'like', '%'.$this->search.'%');
            })
            ->orWhere('loanCode', 'like', '%'.$this->search.'%')
            ->orWhere('status', 'like', '%'.$this->search.'%')
            ->paginate($this->limitPerPage);
        }

        $this->emit('loanPostData');

        return view('livewire.loan.loan-data', ['loans' => $loans]);
    }

    public function detailLoan($id)
    {
        $loan = InventoryLoan::with([
            'inventoryLoanDetails',
            'user',
            'location',
        ])->findOrFail($id);

        // dd($loan);
        $this->getInventoryId = $loan->inventoryLoanDetails[0]->productInventory->inventoryCode;
        $this->loanCode = $loan->loanCode;
        $this->loanStartDate = $loan->loanStartDate;
        $this->loanEndDate = $loan->loanEndDate;
        $this->status = $loan->status;
        $this->loanDescription = $loan->loanDescription;
        $this->loanerUserId = $loan->user->name;
        $this->locationId = $loan->location->locationName;
        // dd($this->getInventoryId);
        $this->isDetailLoanOpen = true;
    }

    public function closeDetailLoan()
    {
        $this->isDetailLoanOpen = false;
    }
}
