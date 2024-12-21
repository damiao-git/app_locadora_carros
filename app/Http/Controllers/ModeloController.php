<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModeloValidator;
use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModeloController extends Controller
{

    public function index()
    {
        $modelos = Modelo::all();
        return response()->json([$modelos], 200);
    }

    public function create()
    {
        //
    }

    public function store(ModeloValidator $request)
    {
        $request->validated();
        $imagem = $request->file("imagem");
        $imagem_urn = $imagem->store('imagens/modelos', 'public');
        $modelo = Modelo::create([
            'marca_id' => $request->marca_id,
            'numero_portas' => $request->numero_portas,
            'lugares' => $request->lugares,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs,
            'nome' => $request->nome,
            'imagem' => $imagem_urn,
        ]);
        return response()->json($modelo, 201);
    }


    public function show($id)
    {
        $modelo = Modelo::find($id);
        if ($modelo == null) {
            return response()->json(
                ['erro' => 'Não encontrado'],
                404
            );
        } else {
            return response()->json($modelo, 200);
        }
    }

    public function edit(Modelo $modelo)
    {
        //
    }


    public function update(ModeloValidator $request, $id)
    {
        $modelo = Modelo::find($id);

        if ($modelo == null) {
            return response()->json(
                ['erro' => 'Não encontrado'],
                404
            );
        } else {
            $request->validated();

            if ($request->file('imagem')) {
                Storage::disk('public')->delete($modelo->imagem);
            }

            $imagem = $request->file("imagem");
            $imagem_urn = $imagem->store('imagens/modelos', 'public');

            $modelo->update(
                [
                    'marca_id' => $request->marca_id,
                    'numero_portas' => $request->numero_portas,
                    'lugares' => $request->lugares,
                    'air_bag' => $request->air_bag,
                    'abs' => $request->abs,
                    'nome' => $request->nome,
                    'imagem' => $imagem_urn,
                ]
            );
            return response()->json($modelo, 200);
        }
    }


    public function destroy($id)
    {
        $modelo = Modelo::find($id);
        if ($modelo == null) {
            return response()->json(
                ['erro' => 'Não encontrado'],
                404
            );
        } else {
            Storage::disk('public')->delete($modelo->imagem);
            $modelo->delete();
            return response()->json(['msg' => 'Removido!'], 200);
        }
    }
}
