<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageVisit;

class VisitorController extends Controller
{
    public function index()
    {
        $visits = PageVisit::where('url', url('/'))->latest()->paginate(50);

        $stats = [
            'total' => PageVisit::where('url', url('/'))->count(),
            'unique_ips' => PageVisit::where('url', url('/'))->distinct('ip')->count('ip'),
            'today' => PageVisit::where('url', url('/'))->whereDate('created_at', today())->count(),
            'countries' => PageVisit::where('url', url('/'))->whereNotNull('country')->distinct('country')->count('country'),
        ];

        return view('admin.visitors.index', compact('visits', 'stats'));
    }

    public function reset()
    {
        PageVisit::truncate();

        return redirect()->route('admin.visitors.index')->with('success', 'Ziyaretçi kayıtları sıfırlandı.');
    }
}
