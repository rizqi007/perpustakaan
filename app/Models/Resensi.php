<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Trashable;

class Resensi extends Model
{
    use HasFactory, Trashable;

    protected $fillable = [
        'title',
        'slug',
        'book_title',
        'author',
        'reviewer_name',
        'content',
        'cover_image',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Parse book details from the content column.
     */
    public function getBookDetailsAttribute()
    {
        $details = [
            'judul' => $this->book_title,
            'penulis' => $this->author,
            'penerbit' => null,
            'tebal' => null,
            'tahun' => null,
            'isbn' => null,
        ];

        // Preprocess HTML content to find keys
        $text = $this->content;
        $text = str_replace(['<br>', '<br/>', '<br />', '</p>', '</div>', '<strong>', '</strong>'], ["\n", "\n", "\n", "\n", "\n", " ", " "], $text);
        $text = str_replace('&nbsp;', ' ', $text);
        $text = html_entity_decode(strip_tags($text));

        // Match patterns using multi-line matching
        if (preg_match('/Penerbit\s*:\s*([^\r\n]+)/i', $text, $matches)) {
            $details['penerbit'] = trim($matches[1]);
        }
        if (preg_match('/Tebal\s*:\s*([^\r\n]+)/i', $text, $matches)) {
            $details['tebal'] = trim($matches[1]);
        }
        if (preg_match('/Tahun Terbit\s*:\s*([^\r\n]+)/i', $text, $matches)) {
            $details['tahun'] = trim($matches[1]);
        }
        if (preg_match('/ISBN\s*:\s*([^\r\n]+)/i', $text, $matches)) {
            $details['isbn'] = trim($matches[1]);
        }

        return $details;
    }

    /**
     * Clean the content by removing leading book metadata.
     */
    public function getCleanedContentAttribute()
    {
        $cleaned = $this->content;
        
        // Clean leading empty/spacing paragraphs
        $cleaned = preg_replace('/^(?:\s*<p[^>]*>(?:\s*|&nbsp;|<br\s*\/?>)*<\/p>)+/i', '', $cleaned);
        
        // Loop to strip leading metadata paragraphs containing book keys
        for ($i = 0; $i < 4; $i++) {
            $cleaned = preg_replace('/^<p[^>]*>(?:(?!<p>).)*?(?:Judul Buku|Identitas Buku|Pengarang|Penulis|Penerbit|Tebal|ISBN|Tahun Terbit).*?<\/p>/is', '', $cleaned);
            $cleaned = preg_replace('/^(?:\s*<p[^>]*>(?:\s*|&nbsp;|<br\s*\/?>)*<\/p>)+/i', '', $cleaned);
        }
        
        return $cleaned;
    }
}
