<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::all();

        return [
            'blogs' => $blogs
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'title' => 'required',
                'body' => 'required'
            ]
        );

        $blog = Blog::create($validated);

        return [
            'message' => "Blog Created Successfully",
            'blog' => $blog
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {

        return [
            'Blog' => $blog
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Blog $blog, Request $request)
    {
        $validated = $request->validate(
            [
                'title' => 'required',
                'body' => 'required'
            ]
        );

        $blog->update($validated);

        return [
            'Blog' => $blog
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {

        $blog->delete();

        return [
            'message' => 'Blog deleted successfully!'
        ];
    }
}
