<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaValidator;
use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $imagem = $request->file("imagem");
        $imagem_urn = $imagem->store('imagens', 'public');
        $marca = Marca::create([
            'nome' => $request->nome,
            'imagem' => $imagem_urn
        ]);
        return response()->json($marca, 201);
    }

    public function show($id)
    {
        $marca = Marca::find($id);
        if ($marca == null) {
            return response()->json(
                ['erro' => 'Não encontrado'],
                404
            );
        } else {
            return response()->json($marca, 201);
        }
    }

    public function update(MarcaValidator $request, $id)
    {
        $marca = Marca::find($id);

        if ($marca == null) {
            return response()->json(
                ['erro' => 'Não encontrado'],
                404
            );
        } else {
            $request->validated();

            if ($request->file('imagem')) {
                Storage::disk('public')->delete($marca->imagem);
            }

            $imagem = $request->file("imagem");
            $imagem_urn = $imagem->store('imagens', 'public');

            $marca->update(
                [
                    'nome' => $request->nome,
                    'imagem' => $imagem_urn
                ]
            );
            return response()->json($marca, 200);
        }
    }

    public function destroy($id)
    {
        $marca = Marca::find($id);
        if ($marca == null) {
            return response()->json(
                ['erro' => 'Não encontrado'],
                404
            );
        } else {
            Storage::disk('public')->delete($marca->imagem);
            $marca->delete();
            return response()->json(['msg' => 'Removido!'], 200);
        }
    }
}
