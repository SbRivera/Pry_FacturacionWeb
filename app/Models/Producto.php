<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property int $stock
 * @property float $precio
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Factura> $facturas
 * @property \Illuminate\Database\Eloquent\Relations\Pivot|\stdClass $pivot
 */
class Producto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'descripcion',
        'stock',
        'precio',
        'is_active'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Relación con facturas (many-to-many)
     */
    public function facturas(): BelongsToMany
    {
        return $this->belongsToMany(Factura::class, 'factura_producto')
                    ->withPivot('cantidad', 'precio_unitario')
                    ->withTimestamps();
    }

    /**
     * Scope para productos activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para productos con stock
     */
    public function scopeWithStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope para productos con stock bajo (menos de 10 unidades)
     */
    public function scopeLowStock($query)
    {
        return $query->where('stock', '<', 10);
    }
}
