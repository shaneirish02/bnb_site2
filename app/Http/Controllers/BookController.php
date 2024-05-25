<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Models\Book;

class BookController extends Controller {

    use ApiResponser;

    private $request;

    public function __construct(Request $request) {

        $this->request = $request;

    }

    public function getBooks() {

        $books = Book::all();

        return response()->json($books, 200);

    }

    /**
     * Return the list of books
     * @return Illuminate\Http\Response
     */
    public function index() {

        $books = Book::all();

        return $this->successResponse($books);

    }

    public function add(Request $request) {

        $rules = [
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'genre' => 'required|max:255',
        ];

        $this->validate($request, $rules);

        $books = Book::create($request->all());

        return $this->successResponse($books, Response::HTTP_CREATED);
    }

    /**
     * Obtains and show one book
     * @return Illuminate\Http\Response
     */
    public function show($id) {

        $books = Book::findOrFail($id);

        return $this->successResponse($books);
    }

    /**
     * Update an existing book details
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        $rules = [
            'title' => 'max:255',
            'author' => 'max:255',
            'genre' => 'max:255',
        ];

        $this->validate($request, $rules);

        $books = Book::findOrFail($id);

        $books->fill($request->all());

        // if no changes happen
        if ($books->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $books->save();

        return $this->successResponse($books);
    }

    /**
     * Remove an existing book
     * @return Illuminate\Http\Response
     */
    public function delete($id) {

        $books = Book::findOrFail($id);

        $books->delete();

        return $this->successResponse($books);
    }
}