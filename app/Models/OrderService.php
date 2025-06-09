<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class OrderService extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'client_id',
        'service_type',
        'description',
        'status',
        'priority',
        'start_date',
        'end_date',
        'estimated_hours',
        'actual_hours',
        'cost_estimate',
        'final_cost',
        'payment_status',
        'notes',
        'location',
        'equipment_needed',
        'approval_status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'estimated_hours' => 'decimal:2',
        'actual_hours' => 'decimal:2',
        'cost_estimate' => 'decimal:2',
        'final_cost' => 'decimal:2',
    ];

    /**
     * The client that owns the service order
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * The technicians assigned to this service order
     */
    public function technicians(): BelongsToMany
    {
        return $this->belongsToMany(Technician::class)
            ->withPivot(['hours_worked', 'role', 'notes'])
            ->withTimestamps();
    }

    /**
     * Scope for active service orders
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'in_progress']);
    }

    /**
     * Scope for completed service orders
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Get the total technician costs for this order
     */
    public function getTechnicianCostsAttribute(): float
    {
        return $this->technicians->sum(function ($technician) {
            return $technician->pivot->hours_worked * $technician->hourly_rate;
        });
    }

    /**
     * Configurações do log de atividade
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'client_id',
                'service_type',
                'description',
                'status',
                'priority',
                'start_date',
                'end_date',
                'estimated_hours',
                'actual_hours',
                'cost_estimate',
                'final_cost',
                'payment_status',
                'notes',
                'location',
                'equipment_needed',
                'approval_status',
            ])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Ordem de serviço foi {$eventName}");
    }
}
