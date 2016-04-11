<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategories;

final class NewsController extends Controller
{

    public function news( News $newsRepository, NewsCategories $newsCategoriesRepository)
    {
        $news = $newsRepository->findallactive();
        $categories = $newsCategoriesRepository->allActive();

        return View('front.news.list', [
            'news' => $news,
            'categories' => $categories,
        ]);
    }

    public function newsCategory( $slug, News $newsRepository, NewsCategories $newsCategoriesRepository)
    {
        $news = $newsRepository->findCategoryBySlug($slug);
        $categories = $newsCategoriesRepository->allActive();

        return View('front.news.list', [
            'news' => $news,
            'thiscategory' => $slug,
            'categories' => $categories,
        ]);
    }

    function detail( $slug, News $newsRepository, NewsCategories $newsCategoriesRepository)
    {

        $thisnew = $newsRepository->findNewBySlug($slug);
        $news = $newsRepository->findLastNews();
        $categories = $newsCategoriesRepository->allActive();

        return view('front.news.detail', [
            'news' => $news,
            'thisnew' => $thisnew,
            'categories' => $categories,
        ]);
    }

}
