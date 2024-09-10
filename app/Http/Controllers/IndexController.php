<?php

namespace App\Http\Controllers;

use App\Models\Task;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = 'http://energeek-app-todo.test/api'; // Ganti dengan URL API eksternal Anda
    }

    public function index()
    {
        $client = new Client();

        try {
            // Ambil data pengguna dari API eksternal
            $userId = 1; // ID pengguna, ini bisa diubah sesuai kebutuhan
            $responseUser = $client->request('GET', "{$this->apiUrl}/users/{$userId}");
            $userData = json_decode($responseUser->getBody()->getContents(), true);
            $user = $userData['data']; // Ambil data dari field "data"

            // Ambil kategori dari API eksternal
            $responseCategory = $client->request('GET', "{$this->apiUrl}/categories");
            $categories = json_decode($responseCategory->getBody()->getContents(), true);

            // Ambil semua tugas dari database
            $tasks = Task::all(); // Jika Anda memiliki logika untuk mengambil tugas berdasarkan pengguna, tambahkan di sini

            return view('index', [
                'user' => $user,
                'categories' => $categories,
                'tasks' => $tasks
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'category_id' => 'required|integer',
                'user_id' => 'required|integer',
            ]);

            // Siapkan data untuk dikirim ke API
            $taskData = [
                'title' => $request->title,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'user_id' => $request->user_id,
            ];

            // Kirim permintaan POST ke API eksternal
            $client = new Client();
            $response = $client->post("{$this->apiUrl}/tasks", [
                'json' => $taskData,
            ]);

            // Cek respons API
            if ($response->getStatusCode() == 201) {
                return redirect()->back()->with('success', 'Task berhasil disimpan!');
            }

            return redirect()->back()->with('error', 'Gagal menyimpan task ke API eksternal.');
        } catch (\Exception $e) {
            Log::error("Error saving task to API: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan task.');
        }
    }

    public function destroy($id)
    {
        try {
            $client = new Client();
            $response = $client->delete("{$this->apiUrl}/tasks/{$id}");

            // Cek respons API
            if ($response->getStatusCode() == 200) {
                return redirect()->back()->with('success', 'Task berhasil dihapus!');
            }

            return redirect()->back()->with('error', 'Gagal menghapus task dari API eksternal.');
        } catch (\Exception $e) {
            Log::error("Error deleting task from API: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus task.');
        }
    }

    // Mengupdate data di API eksternal
    public function update(Request $request, $id)
    {
        try {
            // Validasi input
            $request->validate([
                'judul' => 'required|string',
                'kategori' => 'required|string',
                'deskripsi' => 'nullable|string',
            ]);

            // Siapkan data untuk dikirim ke API
            $taskData = [
                'title' => $request->judul,
                'kategori' => $request->kategori,
                'description' => $request->deskripsi,
            ];

            // Kirim permintaan update ke API eksternal
            $client = new Client();
            $response = $client->put("{$this->apiUrl}/tasks/{$id}", [
                'json' => $taskData,
            ]);

            if ($response->getStatusCode() == 200) {
                return response()->json(['message' => 'Task berhasil diperbarui!']);
            }

            return response()->json(['message' => 'Gagal memperbarui task di API eksternal.'], 500);
        } catch (\Exception $e) {
            Log::error("Error updating task in API: " . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan saat memperbarui data.'], 500);
        }
    }

}
