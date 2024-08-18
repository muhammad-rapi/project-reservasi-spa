<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\CustomerCreated;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserCreatedListener
{
    /**
     * Create the event listener.
     */

    protected  $userModel, $customerModel;

    public function __construct(User $userModel, Customer $customerModel)
    {
        $this->userModel = $userModel;
        $this->customerModel = $customerModel;
    }

    /**
     * Handle the event.
     */
    public function handle(\App\Events\User\UserCreated $event): void
    {
        DB::transaction(function () use ($event) {
            if ($event->user->role != 'admin') {
                $customer = $this->customerModel;
                $customer->create([
                    'users_id' => $event->user->id,
                    'fullname' => $event->user->fullname,
                    'address' => $event->user->address,
                    'gender' => $event->user->gender,
                    'phone_number' => $event->user->phone_number,
                ]);
            }
        });
    }
}
