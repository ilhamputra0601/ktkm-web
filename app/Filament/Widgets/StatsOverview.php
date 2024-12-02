<?php

namespace App\Filament\Widgets;

use App\Models\Reel;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {

        $user = auth()->user();

        return [
            Stat::make('Total Reel Anda', Reel::where('user_id', $user->id)->count()),
            Stat::make('Role Anda', $user?->roles->pluck('name')->join(', ') ?? 'Tidak Ada Role'),
            Stat::make('Divisi Anda', $user?->division?->name ?? 'Belum Ditentukan'),
        ];

    }
}
