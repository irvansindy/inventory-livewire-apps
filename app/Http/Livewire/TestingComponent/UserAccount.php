<?php

namespace App\Http\Livewire\TestingComponent;

use Livewire\Component;
use App\Models\AccountTesting;
use Illuminate\Http\Request;

class UserAccount extends Component
{
    public $accounts, $account, $username, $account_id;
    public $updateMode = false;
    public $inputs = [];
    public $i = 1;

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
        // dd([$this->inputs, $this->account]);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
        unset($this->accounts[$i]);
        // $this->account = array_except($this->account, array($i, 'account', 'username'));
        // dd([$this->inputs, $this->account]);
    }

    public function render()
    {
        $data = AccountTesting::all();
        return view('livewire.testing-component.user-account', ['data' => $data]);
    }

    private function resetInputFields(){
        $this->account = '';
        $this->username = '';
    }

    public function store()
    {
        $this->validate([
            'account.0' => 'required',
            'username.0' => 'required',
            'account.*' => 'required',
            'username.*' => 'required',
        ]);
        
        dd($this->account);


        foreach ($this->account as $key => $value) {
            AccountTesting::create(['account' => $this->account[$key], 'username' => $this->username[$key]]);
        }
        $this->inputs = [];

        $this->resetInputFields();

        session()->flash('message', 'Account Added Successfully.');
    }

}
