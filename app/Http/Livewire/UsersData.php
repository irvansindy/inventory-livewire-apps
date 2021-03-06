<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use PDF;
use App\Exports\UserExport;
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads;
Use Alert;

class UsersData extends Component
{
    use WithFileUploads;

    public $allDataUser, $userId, $name, $email, $username, $roles, $nik, $officeId;
    public $search;
    public $importExportFile;
    public $isModalOpen = 0;
    public $isEditModalOpen = 0;
    public $isModalImportOpen = 0;
    public $isDeleteModalOpen = 0;
    public $isSignatureOpen = 0;
    public $limitPerPage = 3;
    protected $querySearchString = ['search'=> ['except' => '']];
    protected $listeners = [
        'users' => 'userPostData'
    ];

    public function userPostData() {
        $this->limitPerPage = $this->limitPerPage + 1;  
    }

    public function render()
    {
        $user = User::latest()->paginate($this->limitPerPage);

        if($this->search !== null) {
            $user = User::where('name',  'LIKE', '%'.$this->search.'%')
            ->orWhere('username',  'LIKE', '%'.$this->search.'%')
            ->orWhere('roles',  'LIKE', '%'.$this->search.'%')->paginate($this->limitPerPage);
        }

        $this->emit('userPostData');
        return view('livewire.user.users-data', ['users' => $user]);
    }

    public function create() {
        $this->resetCreateUserForm();
        $this->openModal();
    }

    public function openModal() {
        $this->isModalOpen = true;
    }
    
    public function openEditModal() {
        $this->isEditModalOpen = true;
    }

    public function closeModal() {
        $this->isModalOpen = false;
    }

    public function closeEditModal() {
        $this->isEditModalOpen = false;
    }

    public function resetCreateUserForm() {
        $this->name = '';
        $this->email = '';
        $this->username = '';
        $this->roles = '';
        $this->nik = '';
    }

    public function storeUser() {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'username' => 'required|unique:users',
            'roles' => 'required',
            'nik' => 'required',
        ]);

        User::Create([
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'roles' => $this->roles,
            'nik' => $this->nik,
            'password' => Hash::make('123456789'),
        ]);
        alert()->success('SuccessAlert', 'Data created successfully.');

        $this->closeModal();
        $this->resetCreateUserForm();
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->username = $user->username;
        $this->nik = $user->nik;
    
        $this->openEditModal();
    }

    public function updateUser() {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'username' => 'required',
            'nik' => 'required',
        ]);

        User::findOrFail($this->userId)->update([
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'nik' => $this->nik,
        ]);

        alert()->success('SuccessAlert', 'Data updated successfully.');

        $this->closeEditModal();
        $this->resetCreateUserForm();
    }

    public function deleteConfirm($id)
    {

        $this->userId = $id;
        $this->name = User::findOrFail($id)->name;
        $this->isDeleteModalOpen = true;
    }

    public function deleteUser()
    {
        User::findOrFail($this->userId)->delete();
        // session()->flash('message', 'Data deleted successfully.');
        alert()->success('SuccessAlert', 'Data deleted Successfully.');
        $this->isDeleteModalOpen = false;
    }

    public function cancelDelete()
    {
        $this->isDeleteModalOpen = false;
    }

    public function exportPDF()
    {
        // $data = [];
        $data = User::all();

        $pdf = PDF::loadView('livewire.user.report-users', ['data' => $data])->setPaper('a4', 'portrait')->output(); //
        return response()->streamDownload(
            fn() => print($pdf), 'user.pdf'
        );
    }

    public function exportCSV()
    {
        // return Excel::download(new UserExport, 'users.xlsx');
        return Excel::download(new UserExport, 'users.csv');
    }

    public function modalImport()
    {
        $this->isModalImportOpen = true;
    }
    
    public function closeModalImport()
    {
        $this->importExportFile = '';
        $this->isModalImportOpen = false;
    }

    public function importCSV()
    {
        $this->validate([
            'importExportFile' => 'required|mimes:csv,xls,xlsx'
        ]);
        // Excel::import(new UserImport, request()->file('file'));
        Excel::import(new UserImport, $this->importExportFile);
        // return redirect()->back()->with('message','Data Imported Successfully');
        $this->closeModalImport();
        return alert()->success('SuccessAlert', 'Data Imported Successfully.');
    }

    // public function signature()
    // {
    //     $this->signature = true; 
    //     $this->isSignatureOpen = true;
    // }

}
