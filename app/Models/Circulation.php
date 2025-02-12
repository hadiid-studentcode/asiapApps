<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Circulation extends Model
{
    /** @use HasFactory<\Database\Factories\CirculationFactory> */
    use HasFactory;

    protected $table = 'circulations';

    protected $guarded = ['id'];

    // Di model Circulation
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id'); // pastikan 'book_id' adalah nama kolom yang benar
    }


    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
