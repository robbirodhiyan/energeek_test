<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskController extends Controller
{
    /**
     * Menampilkan daftar semua tugas.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    /**
     * Menyimpan tugas baru.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $task = Task::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
            'created_by' => auth()->id(),
        ]);

        return response()->json($task, 201);
    }

    /**
     * Menampilkan detail tugas tertentu.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $task = Task::findOrFail($id);
            return response()->json($task);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Task not found'], 404);
        }
    }

    /**
     * Memperbarui tugas tertentu.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $task = Task::findOrFail($id);
            $task->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'category_id' => $request->input('category_id'),
                'updated_by' => auth()->id(),
            ]);

            return response()->json($task);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Task not found'], 404);
        }
    }

    /**
     * Menghapus tugas tertentu secara soft delete.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $task = Task::findOrFail($id);
            $task->deleted_by = auth()->id();
            $task->save();
            $task->delete();

            return response()->json(['message' => 'Task deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Task not found'], 404);
        }
    }
}
