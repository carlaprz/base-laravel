<?php

namespace App\Http\Controllers;

use App;
use App\Models\Faqs;
use App\Models\FaqsCategories;

class FaqsController extends Controller
{

    public function faqs()
    {

        $repo = App::make(Faqs::class);
        $faqs = $repo->allActiveOrder();

        $repo2 = App::make(FaqsCategories::class);
        $faqsCategories = $repo2->allActive();


        return View('front.faqs.faqs', [
            'faqs' => $faqs,
            'categories' => $faqsCategories,
        ]);
    }

}
