<?php

namespace App\Http\Controllers;

use App\Model\Serie;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    /** @var Serie $serie */
    protected $serie;

    public function __construct()
    {
        $this->serie = app()->make(Serie::class);
    }

    public function index()
    {
        return $this->serie->orderBy('nome','asc')->paginate();
    }

    public function show(int $id)
    {
        $serie = $this->serie->find($id);

        if (is_null($serie)) {
            return response()->json('', 204);
        }

        return response()->json($serie);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        
        $this->serie->fill($data);
        $this->serie->save();

        return response()->json($this->serie->refresh(), 201);
    }

    public function update(int $id, Request $request)
    {
        $serie = $this->serie->find($id);

        if (is_null($serie)) {
            return response()->json(["error" => 'Recurso não encontrado para edição.'], 404);
        }

        $serie->fill($request->all());
        $serie->save();
        
        return response()->json($serie, 200);
    }

    public function destroy(int $id)
    {
        $serie = $this->serie->find($id);

        if (is_null($serie)) {
            return response()->json(["error" => 'Recurso não encontrado para exclusão.'], 404);
        }

        $serie->delete();

        return response()->json('', 204);
    }
}
