<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'date',
        'time',
        'notes',
        'status',
        'confirmation_sent_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
        'confirmation_sent_at' => 'datetime',
    ];
    
    /**
     * Get status badge class
     */
    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'nieuw' => 'bg-blue-100 text-blue-800 border border-blue-300',
            'bevestigd' => 'bg-green-100 text-green-800 border border-green-300',
            'verplaatst' => 'bg-yellow-100 text-yellow-800 border border-yellow-300',
            'geannuleerd' => 'bg-red-100 text-red-800 border border-red-300',
            default => 'bg-gray-100 text-gray-800 border border-gray-300',
        };
    }
    
    /**
     * Check if appointment is upcoming (within next 24 hours)
     */
    public function isUpcoming()
    {
        return $this->date->isToday() || $this->date->isTomorrow();
    }
    
    /**
     * Scope for today's appointments
     */
    public function scopeToday($query)
    {
        return $query->whereDate('date', today());
    }
    
    /**
     * Scope for upcoming appointments
     */
    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', today());
    }
}
