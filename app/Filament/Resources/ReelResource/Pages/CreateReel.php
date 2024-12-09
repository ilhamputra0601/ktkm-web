<?php

namespace App\Filament\Resources\ReelResource\Pages;

use App\Filament\Resources\ReelResource;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateReel extends CreateRecord
{
    protected static string $resource = ReelResource::class;

    protected function getRedirectUrl(): string
    {
        $user = auth()->user();
        $show = $this->record;

            Notification::make()
                ->title('Reel Baru')
                ->success()
                ->body( auth()->user()->name  . ' membuat posting')
                ->actions([
                    Action::make('View')
                        ->url('/reel/'.$show->slug)
                        ->button()
                        ->markAsRead(),
                ])
                ->sendToDatabase($user);


        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Reel Berhasil Dibuat';
    }

}
