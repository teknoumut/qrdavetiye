<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|max:2000',
        ]);

        $message = ContactMessage::create($data);

        try {
            Mail::to(config('mail.admin_address'))->send(new ContactMessageMail($message));
        } catch (\Exception $e) {
            // mail gönderilemezse sorun değil, mesaj yine de kaydedildi
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Mesajınız alındı. En kısa sürede size dönüş yapılacaktır.']);
        }

        return back()->with('success', 'Mesajınız alındı. Teşekkür ederiz!');
    }
}
