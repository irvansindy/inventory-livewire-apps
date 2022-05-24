<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;


class UsersData extends Component
{
    public $allDataUser, $userId, $name, $email, $username, $roles;
    public $search;
    public $isModalOpen = 0;
    public $isEditModalOpen = 0;
    public $limitPerPage = 10;
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
        return view('livewire.users-data', ['users' => $user]);
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
    }

    public function storeUser() {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'username' => 'required|unique:users',
            'roles' => 'required',
        ]);

        User::Create([
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'roles' => $this->roles,
            'password' => Hash::make('123456789'),
        ]);

        session()->flash('message', 'Data added successfully.');

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
    
        $this->openEditModal();
    }

    public function updateUser() {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'username' => 'required',
        ]);

        User::findOrFail($this->userId)->update([
            'name' => $this->name,
                'email' => $this->email,
                'username' => $this->username,
        ]);

        session()->flash('message', 'Data updated successfully.');

        $this->closeEditModal();
        $this->resetCreateUserForm();
    }

    public function deleteConfirm($id)
    {
        $this->userId = $id;
        $this->openModal();
    }

    public function deleteUser($id) {
        User::findOrFail($id)->delete();
        session()->flash('message', 'Data deleted successfully.');
    }

}
