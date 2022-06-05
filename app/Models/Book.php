<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'barcode',
        'book_name',
        'author',
        'publishing_house',
        'types',
        'publication_date',
    ];
}
