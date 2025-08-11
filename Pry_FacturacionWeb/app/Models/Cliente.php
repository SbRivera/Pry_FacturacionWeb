<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'email', 
        'telefono',
        'is_active',
        'user_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relación con facturas
     */
    public function facturas():HasMany
    {
        return $this->hasMany(Factura::class);
    }

    /**
     * Relación con usuario (cliente)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope para clientes activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
