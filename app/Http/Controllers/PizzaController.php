<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pizza;
use Illuminate\Support\Facades\Log;

class PizzaController extends Controller
{
    public function index()
    {
        $pizzas = Pizza::all();
        Log::info('Listado de pizzas mostrado', ['total_pizzas' => count($pizzas)]);

        return view('pizzas', compact('pizzas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|max:2048'
        ]);

        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('pizzas', 'public');
        }

        $pizza = Pizza::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'imagen' => $imagenPath
        ]);

        Log::info('Pizza registrada', [
            'id' => $pizza->id,
            'nombre' => $pizza->nombre,
            'precio' => $pizza->precio
        ]);

        return redirect()->route('pizzas.index')->with('success', 'Pizza registrada con éxito');
    }

    public function destroy(Pizza $pizza)
    {
        Log::warning('Pizza eliminada', [
            'id' => $pizza->id,
            'nombre' => $pizza->nombre
        ]);

        $pizza->delete();

        return redirect()->route('pizzas.index')->with('success', 'Pizza eliminada');
    }

    public function update(Request $request, Pizza $pizza)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('pizzas', 'public');
            $pizza->imagen = $imagenPath;
        }

        $pizza->update($request->only('nombre', 'descripcion', 'precio'));

        Log::info('Pizza actualizada', [
            'id' => $pizza->id,
            'nombre' => $pizza->nombre,
            'precio' => $pizza->precio
        ]);

        return redirect()->route('pizzas.index')->with('success', 'Pizza actualizada');
    }
}
