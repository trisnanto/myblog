<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->where('author_id', Auth::user()->id);

        if (request('title')) {
            $posts->where('title', 'like', '%' . request('title') . '%');
        }

        return view('dashboard.index', ['posts' =>$posts->paginate(5)->withQueryString()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validatedData = $request->validate([
        //     'title' => 'required|min:5|max:255|unique:posts',
        //     'category_id' => 'required|exists:categories,id',
        //     'body' => 'required',
        // ]);

        Validator::make($request->all(), [
            'title' => 'required|min:5|max:255|unique:posts',
            'category_id' => 'required|exists:categories,id',
            'body' => 'required|min:50',
        ], [
            'required' => 'Field :attribute harus diisi.',
            'title.min' => 'Judul minimal 5 karakter.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'title.unique' => 'Judul telah terpakai.',
            'category_id.exists' => ':attribute harus dipilih.',
            'body.required' => ':attribute harus terisi.',
        ], [
            'title' => 'Judul',
            'category_id' => 'Kategori',
            'body' => 'Badan post',
        ])->validate();

        Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
            'category_id' => $request->category_id,
            'author_id' => Auth::user()->id
        ]);

        return redirect('/dashboard')->with([
            'success' => 'Post berhasil dibuat.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // dd($post->title);
        return view('dashboard.show', ['post' => $post]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('dashboard.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Validator::make($request->all(), [
            'title' => 'required|min:5|max:255|unique:posts,title' . $post->id,
            'category_id' => 'required|exists:categories,id',
            'body' => 'required|min:50',
        ], [
            'required' => 'Field :attribute harus diisi.',
            'title.min' => 'Judul minimal 5 karakter.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'title.unique' => 'Judul telah terpakai.',
            'category_id.exists' => ':attribute harus dipilih.',
            'body.required' => ':attribute harus terisi.',
            'body.min' => 'Body post minimal :min karakter.',
        ], [
            'title' => 'Judul',
            'category_id' => 'Kategori',
            'body' => 'Badan post',
        ])->validate();

        $post->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
            'category_id' => $request->category_id,
            'author_id' => Auth::user()->id,
        ]);

        return redirect('/dashboard')->with([
            'success' => 'Post berhasil dirubah.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect('/dashboard')->with([
            'success' => 'Post berhasil dihapus.'
        ]);
    }
}
