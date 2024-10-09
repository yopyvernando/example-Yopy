<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        //get posts
        $posts = Post::latest()->paginate(5);
        //render view with posts
        return view('posts.index', compact('posts'));
    }
    public function create()
    {
        return view('posts.create');
    }
    public function store(Request $request)
    {
        //validate form
        $request->validate([
            'foto_mahasiswa' =>
                'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nim' => 'required|min:5',
            'nama_mahasiswa' => 'required|min:5'
        ]);
        //upload image
        $image = $request->file('foto_mahasiswa');
        $image->storeAs('public/posts', $image->hashName());
        //create post
        Post::create([
            'foto_mahasiswa' => $image->hashName(),
            'nim' => $request->nim,
            'nama_mahasiswa' => $request->nama_mahasiswa
        ]);
        //redirect to index
        return redirect()->route('posts.index')->with([
            'success' => 'Data Berhasil
Disimpan!'
        ]);
    }
}