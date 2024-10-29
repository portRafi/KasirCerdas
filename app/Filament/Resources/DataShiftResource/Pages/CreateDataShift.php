<?php

namespace App\Filament\Resources\DataShiftResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\DataShiftResource;
use App\Models\DataShift;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class CreateDataShift extends CreateRecord
{
    protected static string $resource = DataShiftResource::class;

    protected function beforeCreate(): void
    {
        $exists = DataShift::where('bisnis_id', Auth::user()->bisnis_id)
            ->where('cabangs_id', Auth::user()->cabangs_id)
            ->exists();

        if ($exists) {
            Notification::make()
                ->title('Data Shift Sudah Ada')
                ->body('Anda sudah memiliki data shift untuk cabang ini.')
                ->warning()
                ->send();

            $this->redirect(DataShiftResource::getUrl('index'));
        }
    }
}
