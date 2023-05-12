<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Statamic\Entries\Entry;

class BlogController extends Controller
{
    public function __invoke(): View
    {
        return view('articles.list', [
            'title' => 'Blog',
            'meta_description' => 'A list of articles',
            'articles' => Entry::query()
                ->where('collection', 'articles')
                ->where('date', '<=', now())
                ->where('published', true)
                ->orderBy('date', 'desc')
                ->limit(10)
                ->get(),
        ]);
    }
}
