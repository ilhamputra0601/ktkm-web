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

        $users = \App\Models\User::where('id', '!=', $user->id)->get();

        foreach ($users as $recipient) {
            Notification::make()
                ->title('Postingan Baru')
                ->success()
                ->body($user->name . ' Memosting Reel Baru')
                ->actions([
                    Action::make('View')
                        ->url('/reel/' . $show->slug)
                        ->button()
                        ->markAsRead(),
                ])
                ->sendToDatabase($recipient);
        }

        Notification::make()
        ->title('Reel Anda Berhasil Diposting')
        ->success()
        ->body('Reel Anda berhasil diposting dan terlihat oleh pengguna lain.')
        ->actions([
            Action::make('View')
                ->url('/reel/' . $show->slug)
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
