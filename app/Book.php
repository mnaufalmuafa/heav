<?php

namespace App;

use Illuminate\Support\Facades\DB;
use App\Publisher;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Book extends Model
{
    protected $table = "books";

    protected $fillable = [
        'id', 'title', 'author', 'languageId', 'numberOfPage',
        'price', 'synopsis', 'isDeleted', 'ebookFileId',
        'sampleEbookFileId', 'ebookCoverId', 'publisherId', 'categoryId',
    ];
    
    public static function store($ebookData, $ebookFilesData, $sampleEbookFilesData, $ebookCoverData)
    {
        DB::table('ebook_files')->insert($ebookFilesData);
        DB::table('sample_ebook_files')->insert($sampleEbookFilesData);
        DB::table('ebook_covers')->insert($ebookCoverData);
        DB::table('books')->insert($ebookData);
    }

    public static function getCategories()
    {
        return DB::table('categories')
            ->select('id', 'name')
            ->orderBy('name')
            ->get()
            ->all();
    }

    public static function getLanguages()
    {
        return DB::table('languages')
            ->select('id', 'name')
            ->get()
            ->all();
    }

    public static function getNewEbookFilesId()
    {
        return DB::table('ebook_files')->get()->count() + 1;
    }

    public static function getNewSampleEbookFilesId()
    {
        return DB::table('sample_ebook_files')->get()->count() + 1;
    }

    public static function getNewEbookCoverId()
    {
        return DB::table('ebook_covers')->get()->count() + 1;
    }

    public static function getNewBookId()
    {
        return DB::table('books')->get()->count() + 1;
    }

    public static function getBookDataForDashboardPublisher()
    {
        $userId = session('id');
        $publisherId = Publisher::getPublisherIdWithUserId($userId);
        $books = DB::table('books')
            ->where('publisherId', $publisherId)
            ->where('isDeleted', '0')
            ->get();
        $data = [];
        foreach ($books as $book) {
            array_push($data,[
                "id" => $book->id,
                "title" => $book->title,
                "author" => $book->author,
                "imageURL" => Book::getEbookCoverURL($book->ebookCoverId),
                "synopsis" => $book->synopsis,
                "rating" => Book::getBookRating($book->id),
                "ratingCount" => Book::getBookRatingCount($book->id),
                "soldCount" => Book::getBookSoldCount($book->id),
                "price" => Book::convertPriceToCurrencyFormat($book->price),
            ]);
        }
        return $data;
    }

    private static function getEbookCoverURL($ebookCoverId)
    {
        $fileName = DB::table('ebook_covers')
            ->where('id', $ebookCoverId)
            ->first()
            ->name;
        return url("ebook/ebook_cover/".$ebookCoverId."/".$fileName);
    }

    private static function getBookRating($id)
    {
        $rating = DB::table('reviews')
            ->join('have', 'reviews.haveId', '=', 'have.id')
            ->where('bookId', $id)
            ->avg('rating');
        return $rating ?? 0;
    }

    private static function getBookRatingCount($id)
    {
        $ratingCount = DB::table('reviews')
            ->join('have', 'reviews.haveId', '=', 'have.id')
            ->where('bookId', $id)
            ->count();
        return $ratingCount ?? 0;
    }

    private static function getBookSoldCount($id)
    {
        $soldCount = DB::table('book_snapshots')
            ->join('orders', 'book_snapshots.orderId', '=', 'orders.id')
            ->where('book_snapshots.bookId', $id)
            ->where('orders.status', 'success')
            ->count();
        return $soldCount ?? 0;
    }

    private static function convertPriceToCurrencyFormat($price)
    {
        return number_format($price,0,',','.');
    }

    public static function getBook($bookId)
    {
        return DB::table('books')
            ->where('id', $bookId)
            ->first();
    }

    public static function updateBook($book) {
        $data = [];
        if ($book["title"] != null) {
            $data = array_merge($data, array('title' => $book["title"]));
        }
        if ($book["author"] != null) {
            $data = array_merge($data, array('author' => $book["author"]));
        }
        if ($book["languageId"] != null) {
            $data = array_merge($data, array('languageId' => $book["languageId"]));
        }
        if ($book["numberOfPage"] != null) {
            $data = array_merge($data, array('numberOfPage' => $book["numberOfPage"]));
        }
        if ($book["price"] != null) {
            $data = array_merge($data, array('price' => $book["price"]));
        }
        if ($book["synopsis"] != null) {
            $data = array_merge($data, array('synopsis' => $book["synopsis"]));
        }
        if ($book["categoryId"] != null) {
            $data = array_merge($data, array('categoryId' => $book["categoryId"]));
        }
        $data = array_merge($data, array("updated_at" => Carbon::now()));
        Book::where('id', $book["id"])->update($data);
    }

    public static function uploadCoverPhoto($file, $bookId)
    {
        $photoId = Book::getNewEbookCoverId();
        $photo = $file;
        $nama_file = $photo->getClientOriginalName();
        $tujuan_upload = 'ebook/ebook_cover/'.$photoId;
        $photo->move($tujuan_upload,$nama_file);
        DB::table('ebook_covers')->insert([
            "id" => $photoId,
            "name" => $photo->getClientOriginalName(),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('books')
            ->join('ebook_covers', 'books.ebookCoverId', '=', 'ebook_covers.id')
            ->where('books.id',$bookId)
            ->update([
                "ebookCoverId" => $photoId,
                "books.updated_at" => Carbon::now(),
            ]);
    }

    public static function uploadSampleEbook($file, $bookId)
    {
        $sampleEbookId = Book::getNewSampleEbookFilesId();
        $SampleEbook = $file;
        $nama_file = $SampleEbook->getClientOriginalName();
        $tujuan_upload = 'ebook/sample_ebook_files/'.$sampleEbookId;
        $SampleEbook->move($tujuan_upload,$nama_file);
        DB::table('sample_ebook_files')->insert([
            "id" => $sampleEbookId,
            "name" => $SampleEbook->getClientOriginalName(),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('books')
            ->join('sample_ebook_files', 'books.sampleEbookFileId', '=', 'sample_ebook_files.id')
            ->where('books.id',$bookId)
            ->update([
                "sampleEbookFileId" => $sampleEbookId,
                "books.updated_at" => Carbon::now(),
            ]);
    }
}