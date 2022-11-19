<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(Faq::query()
            ->where('id', '=', $request->input('id'))
            ->first());
    }
}
