<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Circulation;
use App\Models\Denda;
use App\Models\Member; // Tambahkan ini di bagian atas file
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CirculationController extends Controller
{
    public function index()
    {
        $members = Member::all();
        $denda = Denda::first();

        return view('pages.proses.sirkulasi.index', compact('members', 'denda'));
    }

    public function getDataBuku(Request $request)
    {
        $search = $request->search;

        $query = Book::select(
            'code',
            'isbn',
            'judul',
            'pengarang',
            'penerbit',
            'thn_terbit',
            'cover',
            'deskripsi',
            DB::raw('MIN(id) as id'),
            DB::raw('MAX(created_at) as latest_created_at'),
            DB::raw('COUNT(*) as total_qty'),
            DB::raw('SUM(CASE WHEN status = "tersedia" THEN 1 ELSE 0 END) as available_qty')
        )
            ->groupBy('code', 'isbn', 'judul', 'pengarang', 'penerbit', 'thn_terbit', 'cover', 'deskripsi')
            ->orderBy('latest_created_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('isbn', 'like', '%' . $search . '%')
                    ->orWhere('pengarang', 'like', '%' . $search . '%')
                    ->orWhere('penerbit', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%');
            });
        }

        $books = $query->paginate(6);
        return response()->json($books);
    }

    public function getDataCirculation(Request $request)
    {
        $search = $request->search;

        // Query for circulation data
        $query = Circulation::with('book', 'member', 'user')
            ->select(
                'id',
                'kode_pinjam',
                'book_id',
                'member_id',
                'tgl_pinjam',
                'tgl_kembali',
                'status',

            )
            ->where('status', 'pinjam');

        // Apply search filters if search is provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tgl_pinjam', 'like', '%' . $search . '%')
                    ->orWhere('tgl_kembali', 'like', '%' . $search . '%')
                    ->orWhereHas('book', function ($q) use ($search) {
                        $q->where('judul', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('member', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        // Paginate the results
        $circulations = $query->paginate(10);

        // Format dates and add formatted attributes
        $circulations->getCollection()->transform(function ($item) {
            $item->tgl_pinjam_formatted = Carbon::parse($item->tgl_pinjam)->translatedFormat('j F Y');
            $item->tgl_kembali_formatted = Carbon::parse($item->tgl_kembali)->translatedFormat('j F Y');
            return $item;
        });

        //     // Initialize books array
        //     $books = [];

        //     // Check if there is at least one circulation to fetch book data
        //     if ($circulations->count() > 0) {
        //         // Get the first circulation's 'kode_pinjam' to fetch related book title
        //         $judulBuku = Circulation::with('book')->where('kode_pinjam', $circulations->first()->kode_pinjam)->first();

        //         if ($judulBuku) {
        //             // Add book title to the first item in the paginated result
        //             $books[] = [
        //                 'id_buku' => $judulBuku->book->id,
        //                 'judul' => $judulBuku->book->judul,
        //                 'circulations' => $circulations->toArray()['data'],  // Attach circulation data
        //             ];
        //         }
        //     }

        //     // For debugging (you can remove this in production)
        //   dd($books[0]['circulations']);

        // Return paginated data as JSON
        return response()->json($circulations);
    }



    public function loadMore(Request $request)
    {
        $search = $request->search;

        $query = Book::select(
            'isbn',
            'judul',
            'pengarang',
            'penerbit',
            'thn_terbit',
            'cover',
            'deskripsi',
            DB::raw('MIN(id) as id'),
            DB::raw('MAX(created_at) as latest_created_at'), // Add this line
            DB::raw('COUNT(*) as total_qty'),
            DB::raw('SUM(CASE WHEN status = "tersedia" THEN 1 ELSE 0 END) as available_qty')
        )
            ->groupBy('isbn', 'judul', 'pengarang', 'penerbit', 'thn_terbit', 'cover', 'deskripsi')
            ->orderBy('latest_created_at', 'desc'); // Change this line

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('isbn', 'like', '%' . $search . '%')
                    ->orWhere('pengarang', 'like', '%' . $search . '%')
                    ->orWhere('penerbit', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%');
            });
        }

        $page = $request->get('page', 1);
        $books = $query->paginate(3, ['*'], 'page', $page);

        return response()->json($books);
    }



    public function store(Request $request)
    {
        try {
            $request->validate([
                'cartData' => ['required', 'string'],
                'member_id' => ['required', 'exists:members,id'],
                'tgl_pinjam' => ['required', 'date'],
                'tgl_kembali' => ['required', 'date', 'after_or_equal:tgl_pinjam'],
            ]);

            // Decode cart data from JSON
            $cartItems = json_decode($request->cartData, true);

            if (empty($cartItems)) {
                return back()->with('error', 'Tidak ada buku yang dipilih');
            }

            foreach ($cartItems as $item) {
                // Ambil buku yang tersedia sesuai jumlah yang ingin dipinjam
                $availableBooks = Book::where('code', $item['code'])->where('status', 'tersedia')->limit($item['qty'])->get();

                if ($availableBooks->count() < $item['qty']) {
                    return back()->with('error', "Stok buku {$item['code']} tidak mencukupi");
                }

                foreach ($availableBooks as $book) {
                    Circulation::create([
                        'kode_pinjam' => 'P-' . time() . '-' . $book->id,
                        'book_id' => $book->id,
                        'member_id' => $request->member_id,
                        'tgl_pinjam' => $request->tgl_pinjam,
                        'tgl_kembali' => $request->tgl_kembali,
                        'status' => 'pinjam',
                        'user_id' => Auth::id(),
                    ]);

                    // Perbarui status buku menjadi 'dipinjam'
                    $book->update(['status' => 'dipinjam']);
                }
            }

            return back()->with('success', 'Data peminjaman berhasil ditambahkan');
        } catch (\Throwable $th) {
            return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'book_ids' => ['required', 'array'],
                'book_ids.*' => ['exists:books,id'],
                'member_id' => ['required', 'exists:members,id'],
                'tgl_pinjam' => ['required', 'date'],
                'tgl_kembali' => ['required', 'date'],
            ]);

            $circulation = Circulation::findOrFail($id);
            $circulation->update([
                'member_id' => $request->member_id,
                'tgl_pinjam' => $request->tgl_pinjam,
                'tgl_kembali' => $request->tgl_kembali,
                'status' => 'pinjam',
                'user_id' =>
                Auth::id(),
            ]);

            // Ensure book relationship is loaded before calling pluck()
            $circulation->load('book');
            $circulation->book()->sync($request->book_ids);

            return back()->with('success', 'Data peminjaman berhasil diubah');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function updateDenda(Request $request)
    {
        try {
            // Hapus format Rupiah dari input
            $denda = str_replace(['Rp', '.', ' '], '', $request->denda);

            $request->merge(['denda' => $denda]);

            $request->validate([
                'denda' => ['required', 'numeric'],
            ]);

            Denda::updateOrCreate(
                ['id' => 1], // Gunakan ID 1 untuk memastikan hanya ada satu entri denda
                ['jumlah' => $request->denda]
            );

            return back()->with('success', 'Konfigurasi denda berhasil diperbarui');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function returnBook($id_circulation)
    {
        try {
            // Ambil data sirkulasi dengan relasi ke buku
            $circulation = Circulation::with('book')->find($id_circulation);

            // Jika data sirkulasi tidak ditemukan
            if (!$circulation) {
                return response()->json(['status' => 'error', 'message' => 'Data sirkulasi tidak ditemukan'], 404);
            }

            // Ambil data buku
            $book = Book::find($circulation->book_id);

            // Jika buku tidak ditemukan
            if (!$book) {
                return response()->json(['status' => 'error', 'message' => 'Data buku tidak ditemukan'], 404);
            }

            // Update status buku menjadi tersedia
            $book->update(['status' => 'tersedia']);

            // Update status sirkulasi menjadi kembali
            $circulation->update(['status' => 'kembali']);

            return response()->json(['status' => 'success', 'message' => 'Buku berhasil dikembalikan']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan: ' . $th->getMessage()], 500);
        }
    }


    public function extend(Request $request, $id_circulation)
    {
        try {
            $request->validate([
                'jatuhtempo' => ['required', 'date'],
            ]);

            Circulation::where('id', $id_circulation)->update([
                'tgl_kembali' => $request->jatuhtempo,
            ]);



            return response()->json(['status' => 'success', 'message' => 'Tanggal jatuh tempo berhasil diperpanjang']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'Tanggal jatuh tempo gagal diperpanjang']);
        }
    }

    public function edit($id)
    {
        $circulation = Circulation::with('book')->findOrFail($id);
        $books = Book::all();
        $members = Member::all();

        return view('pages.proses.sirkulasi.edit', compact('circulation', 'books', 'members'));
    }

    public function destroy($id)
    {
        try {
            Circulation::where('id', $id)->delete();

            return response()->json(['status' => 'success', 'message' => 'Data peminjaman berhasil dihapus']);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
