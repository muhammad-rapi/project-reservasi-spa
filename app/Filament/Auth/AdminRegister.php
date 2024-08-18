<?php

namespace App\Filament\Auth;

use App\Filament\Pages\Authentication\AdminRegisterPage;
use Illuminate\Contracts\Support\Htmlable;

class AdminRegister extends AdminRegisterPage
{
    public function getHeading(): string|Htmlable
    {
        return __('Admin Register');
    }
}
