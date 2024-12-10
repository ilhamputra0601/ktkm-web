<?php

namespace App\Livewire\Components\Navbar;

use App\Models\Division;
use Livewire\Component;

class MegaMenu extends Component
{
    public function render()
    {
        $divisions = Division::where('id', '!=', 1)->get();
        return view('livewire.components.navbar.megamenu',compact('divisions'));
    }
}
