<?php

namespace App\Http\Controllers;

use App\Models\NewsLetter;
use Illuminate\Http\Request;


class NewsLetterController extends Controller
{
    public function store(Request $request)
    {
    
        $newsletter = NewsLetter::create([
            'name' => $request->name,
            'email'=>$request->email,
        ]);

        // return response()->json([
        //     'message' => 'thank you for submitting'
        // ]);
        return redirect()->back()->with('success',"thank you for submitting");
    }
}
