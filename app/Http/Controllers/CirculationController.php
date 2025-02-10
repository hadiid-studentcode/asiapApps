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

        $books = $query->paginate(6);
        return response()->json($books);
    }

    public function getDataCirculation(Request $request)
    {
        $search = $request->search;

        $query = Circulation::with('book', 'member', 'user')
            ->select(
                'kode_pinjam',
                'member_id',
                'book_id',
                'tgl_pinjam',
                'tgl_kembali',
                'status',
                DB::raw('COUNT(*) as qty')
            )
            ->where('status', 'pinjam')
            ->groupBy('kode_pinjam', 'member_id', 'book_id', 'tgl_pinjam', 'tgl_kembali', 'status');

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
                'tgl_kembali' => ['required', 'date'],
            ]);

            // Decode cart data from JSON
            $cartItems = json_decode($request->cartData, true);

            if (empty($cartItems)) {
                return back()->with('error', 'Tidak ada buku yang dipilih');
            }

            foreach ($cartItems as $item) {
                // Create circulation record for each book with its quantity
                for ($i = 0; $i < $item['qty']; $i++) {
                    Circulation::create([
                        'kode_pinjam' => 'P-' . time() . '-' .  $item['id'],
                        'book_id' => $item['id'],
                        'member_id' => $request->member_id,
                        'tgl_pinjam' => $request->tgl_pinjam,
                        'tgl_kembali' => $request->tgl_kembali,
                        'status' => 'pinjam',
                        'user_id' => Auth::id(),
                    ]);
                }

                // Update book status
                $book = Book::findOrFail($item['id']);
                $book->update(['status' => 'dipinjam']);
            }

            return back()->with('success', 'Data peminjaman berhasil ditambahkan');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
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

    public function returnBook($kode_pinjam)
    {

        try {
            Circulation::where('kode_pinjam', $kode_pinjam)->update([
                'status' => 'kembali',
            ]);
            $circulation = Circulation::select('book_id')->where('kode_pinjam', $kode_pinjam)->first();

            $book = Book::findOrFail($circulation->book_id);
            $book->update(['status' => 'tersedia']);


            return response()->json(['status' => 'success', 'message' => 'Buku berhasil dikembalikan']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'Buku gagal dikembalikan']);
        }
    }

    public function extend(Request $request, $kode_pinjam)
    {
        try {
            $request->validate([
                'jatuhtempo' => ['required', 'date'],
            ]);

            Circulation::where('kode_pinjam', $kode_pinjam)->update([
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
