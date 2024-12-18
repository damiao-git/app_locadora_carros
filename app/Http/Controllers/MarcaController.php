<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaValidator;
use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{

    public function index()
    {
        $marcas = Marca::all();
        return response()->json([$marcas], 200);
    }

    public function store(MarcaValidator $request)
    {

        $request->validated();
        $marca = Marca::create($request->all());
        return response()->json([$marca], 201);
    }

    public function show($id)
    {
        $marca = Marca::find($id);
        if($marca == null){
            return response()->json(
                ['erro' => 'Não encontrado']
            ,404);
        }
        else{
            return response()->json([$marca], 201);
        }
    }

    public function update(MarcaValidator $request, $id)
    {
        $marca = Marca::find($id);
        if($marca == null){
            return response()->json(
                ['erro' => 'Não encontrado']
            ,404);
        }
        else{
            $request->validated();
            $marca->update($request->all());
            return response()->json([$marca], 200);
        }
    }

    public function destroy($id)
    {
        $marca = Marca::find($id);
        if($marca == null){
            return response()->json(
                ['erro' => 'Não encontrado']
            ,404);
        }
        else{
            $marca->delete();
            return response()->json(['msg' => 'Removido!'],200);
        }
    }
}
