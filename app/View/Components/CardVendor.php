<?php

namespace App\View\Components;

use App\Models\Vendor;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardVendor extends Component
{
    /**
     * Create a new component instance.
     */
    public Vendor $vendor;
    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card-vendor');
    }
}
