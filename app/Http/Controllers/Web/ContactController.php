<?php

namespace App\Http\Controllers\Web;

use App\Models\Contact;
use App\Models\MediaSocial;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ContactController
{
    public function index()
    {
        $contacts = Cache::remember('contacts', 3600, function () {
            return Contact::first();
        });
        $sosmeds  = Cache::remember('mediasocials', 3600, function () {
            return MediaSocial::get();
        });

        return view('web.contact', compact('contacts', 'sosmeds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:100',
            'subject' => 'required|string|max:150',
            'message' => 'required|string|max:1000',
        ]);

        // 🔹 Simpan pesan ke database
        Message::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'subject'    => $request->subject,
            'message'    => $request->message,
            'ip_address' => $request->ip(),
        ]);

        return redirect()
            ->route('contact')
            ->with('success', 'Pesan berhasil dikirim!');
    }
}
