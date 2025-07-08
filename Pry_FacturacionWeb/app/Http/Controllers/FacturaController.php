<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFacturaRequest $req)
    {
        DB::transaction(function() use($req){
            $factura = Factura::create([
                'user_id'    => auth()->id(),
                'cliente_id' => $req->cliente_id,
                'total'      => 0,
            ]);
            $total = 0;
            foreach($req->productos as $item){
                $prod = Producto::lockForUpdate()->find($item['id']);
                $prod->decrement('stock', $item['cantidad']);
                $factura->productos()->attach($prod->id, [
                    'cantidad'       => $item['cantidad'],
                    'precio_unitario'=> $prod->precio
                ]);
                $total += $prod->precio * $item['cantidad'];
            }
            $factura->update(['total'=>$total]);
        });

        return redirect()->route('facturas.index')->with('success','Factura creada');
    }

    public function anular(Factura $factura)
    {
        $this->authorize('anular', $factura);

        DB::transaction(function() use($factura){
            foreach($factura->productos as $prod){
                $prod->increment('stock', $prod->pivot->cantidad);
            }
            $factura->update(['estado'=>'anulada']);
        });

        return back()->with('success','Factura anulada');
    }

    /**
     * Display the specified resource.
     */
    public function show(Factura $factura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Factura $factura)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Factura $factura)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Factura $factura)
    {
        //
    }
}
