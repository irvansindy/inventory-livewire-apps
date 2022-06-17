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
    public $mutationId;

    public function render()
    {
        return view('livewire.mutation.mutation-data');
    }
}
