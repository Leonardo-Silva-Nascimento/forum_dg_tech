<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class Forum extends Controller
{

    public function index(Request $request)
    {
        $comments = DB::table('comments')
            ->select(
                'id',
                'texto',
                'hora',
                'tipo',
                'comentario_pai',
                'username'
            )
            ->orderBy('hora', 'DESC')
            ->get();
        // Formatar comentários principais com suas respostas
        $formattedComments = $comments
            ->where('tipo', 1) // Apenas os comentários principais
            ->map(function ($comment) use ($comments) {
                $comment->respostas = $comments
                    ->where('tipo', 2) // Apenas respostas
                    ->where('comentario_pai', $comment->id)
                    ->values(); // Resetar chaves
                return $comment;
            });

        return Inertia::render('User/List', [
            'comments' => $formattedComments,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'texto' => 'required|string',
        ]);
        $name = auth()->user()->name;

        $comentario = DB::table('comments')->insertGetId([
            'texto' => $validated['texto'],
            'username' => $name,
            'tipo' => 1, // Comentário principal
            'hora' => now(),
        ]);


        
    }

    public function storeReply(Request $request)
    {
        $validated = $request->validate([
            'texto' => 'required|string',
            'comentario_pai' => 'required|int'
        ]);
        $name = auth()->user()->name;

        $resposta = DB::table('comments')->insertGetId([
            'texto' => $validated['texto'],
            'username' => $name,
            'tipo' => 2, // Resposta
            'comentario_pai' => $validated['comentario_pai'],
            'hora' => now(),
        ]);

    }

}
