<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::approved()->with('user')->latest()->paginate(12);

        return view('reviews.index', compact('reviews'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:5000',
            'is_anonymous' => 'nullable|boolean',
        ]);

        $data['user_id'] = auth()->id();
        $data['is_anonymous'] = $request->boolean('is_anonymous');

        Review::create($data);

        return redirect()->back()->with('success', 'Yorumunuz alınmıştır. Onaylandıktan sonra yayınlanacaktır.');
    }
}
