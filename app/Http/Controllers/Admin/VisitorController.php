<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageVisit;

class VisitorController extends Controller
{
    public function index()
    {
        $visits = PageVisit::latest()->paginate(50);

        $stats = [
            'total' => PageVisit::count(),
            'unique_ips' => PageVisit::distinct('ip')->count('ip'),
            'today' => PageVisit::whereDate('created_at', today())->count(),
            'countries' => PageVisit::whereNotNull('country')->distinct('country')->count('country'),
        ];

        return view('admin.visitors.index', compact('visits', 'stats'));
    }
}
