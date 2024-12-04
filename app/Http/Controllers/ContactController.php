<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactCreateRequest;
use App\Mail\InquiryMail;
use Illuminate\Support\Facades\Mail;

use App\Models\Inquiry;

class ContactController extends Controller
{
    public function index()
    {
        return inertia('Contact');
    }
    
    public function create(ContactCreateRequest $request)
    {
        $data = $request->validated();
        $inquiry = Inquiry::create($data);
        
        Mail::to($inquiry->email)->send(new InquiryMail($inquiry));
        
        return to_route('contact.index')->with('success', 'Inquiry created!');
    }
}


