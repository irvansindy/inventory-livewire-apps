<?php

namespace App\Http\Livewire\TestingComponent;

use Livewire\Component;
use App\MOdels\User;
use Illuminate\Http\Request;

class TestingDynamicForm extends Component
{
    public $userId, $name, $email, $username, $password, $role, $status;
    public $updateMode = false;
    public $inputUser = [];
    public $i = 1;

    public function addUser($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputUser, $i);
    }

    public function removeUser($i)
    {
        // array_pop($this->inputuser[$i]);
        unset($this->inputUser[$i]);
    }

    public function render()
    {
        // return dd('Testing');
        $data = User::all();
        return view('livewire.testing-component.testing-dynamic-form', ['data' => $data]);
    }

    public function storeUser() 
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'role' => 'required',
            'status' => 'required',
        ]);

        foreach ($this->username as $key => $value) {
            # code...
        }
    }
}
