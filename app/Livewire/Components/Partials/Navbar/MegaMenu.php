<?php

namespace App\Livewire\Components\Partials\Navbar;

use App\Models\Division;
use Livewire\Component;

class MegaMenu extends Component
{
    public function render()
    {
        $divisions = Division::where('id', '!=', 1)->get();
        return view('livewire.components.partials.navbar.megamenu',compact('divisions'));
    }
}
