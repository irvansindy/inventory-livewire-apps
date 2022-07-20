<?php

namespace App\Http\Livewire\Dummy;

use Livewire\Component;
use App\Models\Office;

class DummyMultiSelect extends Component
{

    public $prog_lang = '';
    public $programming_languages = [];

    public $languages = [
        'Python',
        'Php',
        'Java',
        'C',
        'C++',
    ];

    // lifecycle hook sometimes we require it for select2
    public function hydrate()
    {
        $this->emit('select2');
    }

    public function render()
    {
        return view('livewire.dummy.dummy-multi-select');
        // ->extends('layouts.app');;
        // return view('livewire.dummy.dummy-multi-select');
    }

}
