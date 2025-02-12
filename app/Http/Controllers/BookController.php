<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        return view('pages.manajemen.buku.index');
    }

    public function getDataBuku(Request $request)
    {
        $search = $request->search;

        $query = Book::select(
            'code',
            'judul',
            'isbn',
            'pengarang',
            'penerbit',
            'thn_terbit',
        
            'cover',
            'deskripsi',
            DB::raw('COUNT(id) as qty'), // Menghitung jumlah buku berdasarkan judul
            DB::raw('MAX(created_at) as latest_created_at'), // Mengambil tanggal terbaru dalam grup
        )
            ->groupBy('code', 'judul', 'isbn', 'pengarang', 'penerbit', 'thn_terbit',  'cover', 'deskripsi')
            ->orderByDesc('latest_created_at'); // Urutkan berdasarkan buku terbaru

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('isbn', 'like', '%' . $search . '%')
                    ->orWhere('pengarang', 'like', '%' . $search . '%')
                    ->orWhere('penerbit', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%');
            });
        }

        $books = $query->paginate(10);

        return response()->json($books);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {

            if ($request->isbnScan) {
                $response = Http::get('https://www.googleapis.com/books/v1/volumes?q=isbn:' . $request->isbnScan . '&key=' . env('API_KEY_GOOGLE_CONSOLE'));
                $data = $response->json();

                if ($data['totalItems'] == 0) {
                    return response()->json([
                        'status' => 'warning',
                        'message' => 'Buku tidak ditemukan',
                    ], 202);
                }

                $bookData = $data['items'][0]['volumeInfo'];
                $judul_buku = $bookData['title'];
                $ISBN_buku = $bookData['industryIdentifiers'][0]['identifier'];
                $pengarang = $bookData['authors'][0];
                $penerbit = $bookData['publisher'];
                $Tahun = $bookData['publishedDate'] ?? null;

                $data = [
                    'judul' => $judul_buku,
                    'isbn' => $ISBN_buku,
                    'pengarang' => $pengarang,
                    'penerbit' => $penerbit,
                    'thn_terbit' => $Tahun,
                ];

                $book = new Book;
                $book->code = 'B-' . rand(1000, 9999);
                $book->isbn = $request->isbnScan;
                $book->judul = $data['judul'];
                $book->pengarang = $data['pengarang'];
                $book->penerbit = $data['penerbit'];
                $book->thn_terbit = $data['thn_terbit'];
                $book->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Data buku berhasil ditambahkan',
                ], 200);
            } else {
                $data = $request->validate([
                    'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
                    'judul' => ['required', 'string'],
                    'pengarang' => ['required', 'string'],
                    'penerbit' => ['required', 'string'],
                    'thn_terbit' => ['required', 'string'],
                    'deskripsi' => ['nullable', 'string'],
                ]);
                $kode = 'B-' . rand(1000, 9999);

                for ($i = 1; $i <= $request->jumlah; $i++) {

                    $book = new Book;

                    // jika ada cover yang diupload masukkan ke dalam storage
                    if ($request->hasFile('cover')) {
                        $cover = $request->file('cover');
                        $cover_path = $cover->store('buku/cover');
                        $book->cover = $cover_path;
                    }


                    $book->isbn = $request->isbn;
                    $book->code = $kode;
                    $book->judul = $request->judul;
                    $book->pengarang = $request->pengarang;
                    $book->penerbit = $request->penerbit;
                    $book->thn_terbit = $request->thn_terbit;
                    $book->status = 'tersedia';
                    $book->deskripsi = $request->deskripsi;
                    $book->save();
                }

                return back()->with('success', 'Data buku berhasil ditambahkan');
            }
        } catch (\Throwable $th) {

            return back()->with('error', 'Data buku gagal ditambahkan: ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $buku)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $buku)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $codes)
    {
        try {
            $books = Book::where('code', $codes)->get();


            foreach ($books as $book) {
                // jika ada cover yang diupload hapus gambar lama dan masukkan ke dalam storage
                if ($request->hasFile('cover')) {
                    // hapus gambar lama
                    $book->cover && Storage::delete($book->cover);

                    $cover = $request->file('cover');
                    $cover_path = $cover->store('buku/cover');
                    $book->cover = $cover_path;
                }

                $book->judul = $request->judul;
                $book->isbn = $request->isbn;
                $book->pengarang = $request->pengarang;
                $book->penerbit = $request->penerbit;
                $book->thn_terbit = $request->thn_terbit;
                $book->deskripsi = $request->deskripsi;

                $book->save();
            }


            return response()->json([
                'status' => 'success',
                'message' => 'Data buku berhasil di update',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data buku gagal di update: ' . $th->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($codes)
    {

        try {

            Book::where('code', $codes)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data buku berhasil di hapus',
            ], 200);
        } catch (\Throwable $th) {
            return back()->with('error', 'Data buku gagal dihapus: ' . $th->getMessage());
        }
    }
}
