<?php

namespace App\Http\Middleware;

use App\Models\DataShift;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ShiftAuthenticate extends Middleware
{
    /**
     * @param  array<string>  $guards
     */
    protected function authenticate($request, array $guards)
    {
        $guard = Filament::auth();

        if (! $guard->check()) {
            $this->unauthenticated($request, $guards);
            return;
        }

        $this->auth->shouldUse(Filament::getAuthGuard());

        /** @var Model $user */
        $user = $guard->user();

        // if ($user->roles === 'kasir') {
        //     $shift1 = $user->shift === '1'; // Shift pagi
        //     $shift2 = $user->shift === '2'; // Shift sore

        //     $shiftData1 = DataShift::where([
        //         ['bisnis_id', '=', Auth::user()->bisnis_id],
        //         ['cabangs_id', '=', Auth::user()->cabangs_id],
        //         ['shift', '=', '1'],
        //     ])->first();

        //     $shiftData2 = DataShift::where([
        //         ['bisnis_id', '=', Auth::user()->bisnis_id],
        //         ['cabangs_id', '=', Auth::user()->cabangs_id],
        //         ['shift', '=', '2'],
        //     ])->first();

        //     if ($shiftData1) {
        //         $shiftStart1 = $shiftData1->shift_start;
        //         $shiftEnd1 = $shiftData1->shift_end;
        //     }

        //     if ($shiftData2) {
        //         $shiftStart2 = $shiftData2->shift_start;
        //         $shiftEnd2 = $shiftData2->shift_end;
        //     }

        //     $now = Carbon::now();
        //     $currentHour = $now->format('H:i');

        //     if ($shift1) { // Shift pagi
        //         if ($currentHour < $shiftStart1 || $currentHour > $shiftEnd1) {
        //             Auth::logout();
        //             Inertia::location(route('login')); 
        //             return;
        //         }
        //     } elseif ($shift2) { // Shift sore
        //         if ($currentHour < $shiftStart2 || $currentHour > $shiftEnd2) {
        //             Auth::logout();
        //             Inertia::location(route('login')); 
        //             return;
        //         }
        //     } else {
        //         abort(404, 'Shift tidak valid.');
        //     }
        //     // Inertia::location(route('pos'));     
        // }

        $panel = Filament::getCurrentPanel();

        abort_if(
            $user instanceof FilamentUser ? 
                (! $user->canAccessPanel($panel)) : 
                (config('app.env') !== 'local'),
            403,
        );
    }

    protected function redirectTo($request): ?string
    {
        return Filament::getLoginUrl();
    }
}
