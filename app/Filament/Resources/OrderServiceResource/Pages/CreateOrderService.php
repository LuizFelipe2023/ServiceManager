<?php

namespace App\Filament\Resources\OrderServiceResource\Pages;

use App\Filament\Resources\OrderServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrderService extends CreateRecord
{
    protected static string $resource = OrderServiceResource::class;

    public static function canAccess(array $parameters = []): bool
    {
        return auth()->user()?->role === 'admin' || auth()->user()?->role == 'manager' || auth()->user()?->role == 'user';
    }
}
