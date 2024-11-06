<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class BlogController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */

    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show']),
        ];
    }

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

        $blog = $request->user()->posts()->create($validated);

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

        if (! Gate::allows('modify', $blog)) {
            return [
                'message' => 'You are not authorized!'
            ];
        }

        $validated = $request->validate(
            [
                'title' => 'required',
                'body' => 'required'
            ]
        );

        $blog->update($validated);

        return [
            'message' => 'Blog Updated Successfully!',
            'blog' => $blog
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if (! Gate::allows('modify', $blog)) {
            return [
                'message' => 'You are not authorized!'
            ];
        }

        $blog->delete();

        return [
            'message' => 'Blog deleted successfully!'
        ];
    }
}
