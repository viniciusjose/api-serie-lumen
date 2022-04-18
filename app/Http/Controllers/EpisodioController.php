<?php

namespace App\Http\Controllers;

use App\Model\Episodio;
use App\Model\Serie;
use Illuminate\Http\Request;

class EpisodioController extends Controller
{
    /** @var Serie $serie */
    protected $episodio;

    public function __construct()
    {
        $this->episodio = app()->make(Episodio::class);
    }

    public function index()
    {
        return $this->episodio->all();
    }

    public function show(int $id)
    {
        $episodio = $this->episodio->find($id);

        if (is_null($episodio)) {
            return response()->json('', 204);
        }

        return response()->json($episodio);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        
        $this->episodio->fill($data);
        $this->episodio->save();

        return response()->json($this->episodio->refresh(), 201);
    }

    public function update(int $id, Request $request)
    {
        $episodio = $this->episodio->find($id);

        if (is_null($episodio)) {
            return response()->json(["error" => 'Recurso não encontrado para edição.'], 404);
        }

        $episodio->fill($request->all());
        $episodio->save();
        
        return response()->json($episodio, 200);
    }

    public function destroy(int $id)
    {
        $episodio = $this->episodio->find($id);

        if (is_null($episodio)) {
            return response()->json(["error" => 'Recurso não encontrado para exclusão.'], 404);
        }

        $episodio->delete();

        return response()->json('', 204);
    }

    public function episodiosPorSerie(int $serie_id)
    {
        $episodios = $this->episodio->where('serie_id', $serie_id)
            ->orderBy('temporada', 'asc');

        if($episodios->get()->isEmpty()) {
            return response()->json('', 204);
        }

        return $episodios->paginate();
    }
}
