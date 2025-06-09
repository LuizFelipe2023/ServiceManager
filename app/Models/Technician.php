<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Technician extends Model
{
    use SoftDeletes, HasFactory, LogsActivity;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'mobile',
        'specialization',
        'certification_number',
        'certification_expiry',
        'hourly_rate',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'hire_date',
        'termination_date',
        'emergency_contact_name',
        'emergency_contact_phone',
        'notes',
        'active',
        'photo_path',
    ];

    protected $casts = [
        'certification_expiry' => 'date',
        'hire_date' => 'date',
        'termination_date' => 'date',
        'active' => 'boolean',
        'hourly_rate' => 'decimal:2',
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function orderServices()
    {
        return $this->belongsToMany(OrderService::class, 'order_service_technician')
            ->withPivot(['hours_worked', 'role', 'notes'])
            ->withTimestamps();
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'first_name',
                'last_name',
                'email',
                'phone',
                'mobile',
                'specialization',
                'certification_number',
                'certification_expiry',
                'hourly_rate',
                'address',
                'city',
                'state',
                'zip_code',
                'country',
                'hire_date',
                'termination_date',
                'emergency_contact_name',
                'emergency_contact_phone',
                'notes',
                'active',
                'photo_path',
            ])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Técnico foi {$eventName}");
    }
}
