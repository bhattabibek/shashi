<?php

namespace App\Http\Controllers;

use App\Models\NewsLetter;
use Illuminate\Http\Request;


class NewsLetterController extends Controller
{
    public function store(Request $request)
    {
        NewsLetter::create([
            'name' => $request->name,
            'email'=>$request->email,
        ]);

        // to send email to admin
        
        return response()->json([
            'message' => 'thank you for submitting'
        ]);
    }
}
