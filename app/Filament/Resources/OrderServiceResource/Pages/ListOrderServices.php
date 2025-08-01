<?php

namespace App\Filament\Resources\OrderServiceResource\Pages;

use App\Filament\Resources\OrderServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrderServices extends ListRecords
{
    protected static string $resource = OrderServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public static function canAccess(array $parameters = []): bool
    {
        return auth()->user()?->role === 'admin' || auth()->user()?->role == 'manager' || auth()->user()?->role == 'user';
    }
}
