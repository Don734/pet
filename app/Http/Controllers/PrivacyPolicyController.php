<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicy;

class PrivacyPolicyController extends Controller
{
    public function show()
    {
        $documents = PrivacyPolicy::get();
        return view('privacy_policy', compact('documents'));
    }
}
