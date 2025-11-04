<?php

namespace App\Http\Controllers\Web;

use App\Models\Contact;
use App\Models\MediaSocial;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController
{
    public function index() {

        $contacts = Cache::remember('contacts', 3600, function () {
            return Contact::first();
        });
        $sosmeds  = Cache::remember('mediasocials', 3600, function () {
            return MediaSocial::get();
        });
        $services = Cache::remember('services', 3600, function() {
            return Service::where('status', '1')->get();
        });
        $projects = Cache::remember('projects', 3600, function() {
            return Project::with('images')->orderByDesc('year')->take(6)->get();
        });
        $testimonials = Cache::remember('testimonials', 3600, function() {
            return Testimonial::get();
        });
        $posts = Cache::remember('posts', 900, function() {
            return Post::where('status', 'published')
                ->with('category')
                ->latest()
                ->take(3)
                ->get();
        });

        return view('web.home', compact('contacts','services', 'projects', 'testimonials', 'posts', 'sosmeds'));
    }
}
