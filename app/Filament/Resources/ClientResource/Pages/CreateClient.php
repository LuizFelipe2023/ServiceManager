<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;


class CreateClient extends CreateRecord
{
    protected static string $resource = ClientResource::class;

    public static function canAccess(array $parameters = []): bool
    {
        return auth()->user()?->role === 'admin' || auth()->user()?->role == 'manager';
    }


}
