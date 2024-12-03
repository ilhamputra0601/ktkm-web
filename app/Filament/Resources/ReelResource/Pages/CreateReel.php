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

            Notification::make()
                ->title('Reel Baru')
                ->success()
                ->body( auth()->user()->name  . ' membuat posting')
                ->actions([
                    Action::make('View')
                        ->url('https://www.instagram.com/il.pra/')
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
