<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookRequest;
use App\Models\Book;
use Illuminate\Support\Str;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::latest()->paginate(10);
        return view('admin.pages.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statusOptions = StatusEnum::lists();
        return view('admin.pages.books.create', compact('statusOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('books');
        }
        Book::create($data);
        $notification = Str::toastMsg(config('custom.msg.create'), 'success');
        return redirect()->route('admin.books.index')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $statusOptions = StatusEnum::lists();
        return view('admin.pages.books.edit', compact('book', 'statusOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, Book $book)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('books');
        }

        $book->update($data);
        $notification = Str::toastMsg(config('custom.msg.update'), 'success');
        return redirect()->route('admin.books.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    
    public function destroy(Book $book)
    {
        try {
            // Delete the record
            Book $book->delete();

            // Return JSON response for AJAX requests
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Record deleted successfully!'
                ]);
            }

            // Return redirect for regular requests
            $notification = Str::toastMsg(config('custom.msg.delete'),'success');
            return redirect()->back()->with($notification);
            
        } catch (\Exception $e) {
            // Return JSON response for AJAX requests
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete record: ' . $e->getMessage()
                ], 500);
            }

            // Return redirect for regular requests
            return redirect()->back()->with('error', 'Failed to delete record: ' . $e->getMessage());
        }
    }
}
