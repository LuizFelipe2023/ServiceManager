<?php

namespace App\Filament\Resources\OrderServiceResource\Pages;

use App\Filament\Resources\OrderServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOrderService extends ViewRecord
{
    protected static string $resource = OrderServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public static function canAccess(array $parameters = []): bool
    {
        return auth()->user()?->role === 'admin' || auth()->user()?->role == 'manager' || auth()->user()?->role == 'user';
    }
}
