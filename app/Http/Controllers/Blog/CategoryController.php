<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Statamic\Entries\Entry;
use Statamic\Facades\Term;

class CategoryController extends Controller
{
    public function __invoke(string $slug): View
    {
        $taxonomy = Term::query()
            ->where('taxonomy', 'category')
            ->where('slug', $slug)
            ->first();

        return view('articles.list', [
            'title' => $taxonomy->title(),
            'meta_description' => strip_tags($taxonomy->content),
            'articles' => Entry::query()
                ->where('collection', 'articles')
                ->where('date', '<=', now())
                ->whereTaxonomy('category::'.$slug)
                ->orderBy('date', 'desc')
                ->limit(10)
                ->get(),
        ]);
    }
}
