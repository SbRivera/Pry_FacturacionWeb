<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property int $user_id
 * @property int $cliente_id
 * @property string $numero_factura
 * @property float $total
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Cliente $cliente
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Producto> $productos
 */
class Factura extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'cliente_id',
        'total',
        'estado',
        'numero_factura'
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    /**
     * Relación con el usuario que creó la factura
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el cliente
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relación con productos (many-to-many)
     */
    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(Producto::class, 'factura_producto')
                    ->withPivot('cantidad', 'precio_unitario')
                    ->withTimestamps();
    }

    /**
     * Scope para facturas activas
     */
    public function scopeActive($query)
    {
        return $query->where('estado', 'activa');
    }

    /**
     * Scope para facturas anuladas
     */
    public function scopeAnuladas($query)
    {
        return $query->where('estado', 'anulada');
    }

    /**
     * Boot method para generar número de factura automáticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($factura) {
            if (empty($factura->numero_factura)) {
                $factura->numero_factura = 'FAC-' . str_pad(
                    (string)(static::count() + 1), 
                    6, 
                    '0', 
                    STR_PAD_LEFT
                );
            }
        });
    }
}
