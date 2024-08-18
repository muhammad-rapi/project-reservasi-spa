<?php

namespace App\Filament\Auth;

use App\Filament\Pages\Authentication\CustomerRegisterPage;
use Illuminate\Contracts\Support\Htmlable;

class CustomerRegister extends CustomerRegisterPage
{
    public function getHeading(): string|Htmlable
    {
        return __('Customer Register');
    }
}
