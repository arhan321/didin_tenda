<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\About;
use App\Models\Homef;
use App\Models\About2;
use App\Models\Clientf;
use App\Models\Contact;
use App\Models\Service;
use App\Models\Setting;
use App\Models\ProductF;
use App\Models\SocialMedia; 
use Illuminate\Http\Request;

class frontend extends Controller
{
    public function home(Request $request)
    {
        // Fetch homepage content
        $Home = Homef::all();
        $about = About::all();
        $about2 = About2::all();
        $services = Service::all();
        $products = ProductF::all();
        $team = Team::all();
        $clients = Clientf::all();
        $settings = Setting::all();
        $socialmedias = SocialMedia::all();
    
        // If the request is POST, validate and process contact form submission
        if ($request->isMethod('post')) {
            // Validate the request data
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
            ]);
    
            // Store the contact message
            Contact::create([
                'full_name' => $request->input('name'),
                'email' => $request->input('email'),
                'subject' => $request->input('subject'),
                'message' => $request->input('message'),
            ]);
    
            // Add a success message
            $successMessage = 'Your message has been sent successfully!';
        }
    
        // Return the view with homepage content and success message if available
        return view('frontend.index', compact('Home', 'about', 'about2', 'services', 'products', 'team', 'clients', 'settings', 'socialmedias'))
               ->with('success', $successMessage ?? null);
    }
    public function post(Request $request)
    {
        // If the request is POST, validate and process contact form submission
        if ($request->isMethod('post')) {
            // Validate the request data
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
            ]);
    
            // Store the contact message
            Contact::create([
                'full_name' => $request->input('name'),
                'email' => $request->input('email'),
                'subject' => $request->input('subject'),
                'message' => $request->input('message'),
            ]);
    
            // Add a success message to the session
            $request->session()->flash('success', 'Your message has been sent successfully!');
    
            // Redirect to the same contact page after submission
            return redirect()->route('frontend.index'); // Ensure 'contact' is defined in your routes
        }
    
        // Return the contact form view
        return view('frontend.contact');
    }
    
    
}
