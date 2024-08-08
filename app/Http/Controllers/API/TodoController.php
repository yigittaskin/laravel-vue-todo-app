<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Tüm görevleri listeleme
     */
    public function index()
    {
        // Tüm görevleri veritabanından çek ve JSON formatında döndür
        return Todo::all();
    }

    /**
     * Yeni bir görev oluşturma
     */
    public function store(Request $request)
    {
        // Görevi doğrula ve veritabanına kaydet
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $todo = Todo::create([
            'title' => $request->title,
            'completed' => false,
        ]);

        return response()->json($todo, 201);
    }

    /**
     * Belirli bir görevi görüntüleme
     */
    public function show(Todo $todo)
    {
        // Verilen ID'ye sahip görevi döndür
        return response()->json($todo);
    }

    /**
     * Görevi güncelleme
     */
    public function update(Request $request, Todo $todo)
    {
        // Görevi doğrula ve güncelle
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'completed' => 'sometimes|required|boolean',
        ]);

        $todo->update($request->all());

        return response()->json($todo);
    }

    /**
     * Görevi silme
     */
    public function destroy(Todo $todo)
    {
        // Görevi veritabanından sil
        $todo->delete();

        return response()->json(null, 204);
    }
}
