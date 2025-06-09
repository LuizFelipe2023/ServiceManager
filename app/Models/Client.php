<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Client extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'name',           
        'email',          
        'phone',          
        'mobile',         
        'document',      
        'type',           
        'zip_code',       
        'address',        
        'number',         
        'complement',     
        'neighborhood',   
        'city',           
        'state',          
        'active',         
        'notes',
        'photo'           
    ];

    public function orders()
    {
        return $this->hasMany(OrderService::class);
    }

    /**
     * Configurações do log de atividade
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            // Quais atributos devem ser registrados nas mudanças
            ->logOnly([
                'name',
                'email',
                'phone',
                'mobile',
                'document',
                'type',
                'zip_code',
                'address',
                'number',
                'complement',
                'neighborhood',
                'city',
                'state',
                'active',
                'notes',
                'photo',
            ])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Cliente foi {$eventName}");
    }
}
