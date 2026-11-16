<?php
namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $services     = Service::with('category')->latest()->take(4)->get();
        $testimonials = Testimonial::approved()->with('customer.user')->latest()->take(3)->get();

        return view('home', compact('services', 'testimonials'));
    }
}
