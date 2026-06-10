<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|max:20',
            'subject' => 'required',
            'message' => 'required|min:10',
            'privacy' => 'required'
        ]);

        // Logic untuk mengirim email atau menyimpan ke database
        
        return back()->with('success', 'Pesan Anda berhasil dikirim! Kami akan merespons dalam 24 jam.');
    }
}