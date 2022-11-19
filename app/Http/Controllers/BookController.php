<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    const FIND_URL = 'https://www.googleapis.com/books/v1/volumes?q=';

    public function index(Request $request)
    {
        $list = Book::all()
            ->where('profile_id', '=', $request->input('profile_id'))
            ->where('is_read', '=', $request->input('is_read'))
            ->where('in_progress', '=', $request->input('in_progress'));

        if (!$list) {
            return response()->json(['error' => 'Not Found'], 400);
        }

        return response()->json($list);
    }

    public function store(Request $request)
    {
        $newBook = new Book();
        $newBook->fill($request->all());

        if ($newBook->save()) {
            return response()->json($newBook, 201);
        }

        return response()->json(['error' => 'Unable to create'], 400);
    }


    public function search(Request $request)
    {
        $response = Http::get(self::FIND_URL . $request->input('query'));

        $foundBooks = json_decode($response->body())->items;
        $info = $foundBooks[0]->volumeInfo;

        $data = [
            'name'   => $info->title,
            'poster' => $info->imageLinks ?: null,
            'pages'  => $info->pageCount ?: null,
            'genre'  => $info->categories ?: null
        ];

        return response()->json($data);
    }

    public function mark(Request $request)
    {
        $book = Book::query()
            ->where('id', '=', $request->input('book_id'))
            ->first();

        $book->fill($request->all())->save();

        return response()->json($book);
    }
}
