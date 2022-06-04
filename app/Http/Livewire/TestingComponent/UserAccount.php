<?php

namespace App\Http\Livewire\TestingComponent;

use Livewire\Component;
use App\Models\AccountTesting;
use Illuminate\Http\Request;

class UserAccount extends Component
{
    public function render()
    {
        return view('livewire.testing-component.user-account');
    }
}
