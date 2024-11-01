<?php

namespace App\Http\Middleware;

use App\Models\DataShift;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ShiftAuthenticate extends Middleware
{
    /**
     * @param  array<string>  $guards
     */
    protected function authenticate($request, array $guards): void
    {
        $guard = Filament::auth();

        if (! $guard->check()) {
            $this->unauthenticated($request, $guards);

            return;
        }

        $this->auth->shouldUse(Filament::getAuthGuard());

        /** @var Model $user */
        $user = $guard->user();
        // dd($user);
        if ($user->hasRole('kasir')) {
            $shift1 = $user->shift === '1';
            $shift2 = $user->shift === '2';

            $shiftData1 = DataShift::where([
                ['bisnis_id', '=', Auth::user()->bisnis_id],
                ['cabangs_id', '=', Auth::user()->cabangs_id],
                ['shift', '=', '1'],
            ])->first();

            $shiftData2 = DataShift::where([
                ['bisnis_id', '=', Auth::user()->bisnis_id],
                ['cabangs_id', '=', Auth::user()->cabangs_id],
                ['shift', '=', '2'],
            ])->first();


            if ($shiftData1) {
                $shiftStart1 = $shiftData1->shift_start;
                $shiftEnd1 = $shiftData1->shift_end;
            }

            if ($shiftData2) {
                $shiftStart2 = $shiftData2->shift_start;
                $shiftEnd2 = $shiftData2->shift_end;
            }
            $now = Carbon::now();
            $currentHour = $now->format('H:i');

            if ($shift1) { //pagi
                $shiftStart1;
                $shiftEnd1;
            } elseif ($shift2) { //sore
                $shiftStart2;
                $shiftEnd2;
            } else {
                abort(404, 'Shift tidak valid.');
            }

            if ($shift1) {
                if ($currentHour < $shiftStart1 || $currentHour > $shiftEnd1) {
                    Auth::logout();
                    abort(403, 'Anda hanya bisa login selama shift kerja Anda.');
                }
            } else if ($shift2) {
                if ($currentHour < $shiftStart2 || $currentHour > $shiftEnd2) {
                    Auth::logout();
                    abort(403, 'Anda hanya bisa login selama shift kerja Anda.');
                }
            }
        }

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
