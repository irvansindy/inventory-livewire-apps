<?php

namespace App\Http\Livewire\Testing;

use Illuminate\Support\Str;
use Livewire\Component;

class TestingAlpinsJs extends Component
{
    public $signature;
    
    public function render()
    {
        return view('livewire.testing.signature-pad-base64');
    }

    public function submit()
    {
        dd($this->signature);
        $this->validate([
            'signature' => 'required',
        ]);

        \Storage::put('signatures/signature.png', base64_decode(Str::of($this->signature)->after(',')));
    }
}
