<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:255',
            'email' => 'required|email',
            'topik' => 'required|string',
            'pesan' => 'required|string',
        ]);

        Mail::to('twoorbital@gmail.com')->send(new ContactMail($request->all()));

        return back()->with('success', 'Pesan berhasil dikirim! Kami akan membalas secepatnya.');
    }
}