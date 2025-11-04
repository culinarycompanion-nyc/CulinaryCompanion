<?php

namespace App\Http\Controllers;

use App\Mail\FeedbackMail;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactFormController extends Controller
{
    //
    public function contact()
    {
        return view('contact');
    }

    public function submit()
    {
        $mode = request('form_mode');

        $rules = [
            'message' => 'required|string',
        ];

        if (request()->filled('name')) {
            $rules['name'] = 'required|string|max:255';
        }

        if (request()->filled('email')) {
            $rules['email'] = 'required|email|max:255';
        }

        $validated = request()->validate($rules);


        // DO STUFF HERE

        Feedback::create([
            'name' => $validated['name'] ?? null,
            'email' => $validated['email'] ?? null,
            'message' => $validated['message'],
        ]);

        Mail::to('feedback.culinarycompanion@gmail.com')->queue(new FeedbackMail($validated));


        return back()->with('success', $mode === 'join'
            ? 'Thanks for reaching out! We’ll be in touch soon.'
            : 'Thanks for your feedback! We appreciate your input.');
    }


}
