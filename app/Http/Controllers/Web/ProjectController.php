<?php

namespace App\Http\Controllers\Web;

use App\Models\Contact;
use App\Models\MediaSocial;
use App\Models\Project;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProjectController
{
    public function index() {
        $contacts = Cache::remember('contacts', 3600, function () {
            return Contact::first();
        });
        $sosmeds  = Cache::remember('mediasocials', 3600, function () {
            return MediaSocial::get();
        });
        $projects = Cache::remember('projects', 3600, function() {
            return Project::with('images')->orderByDesc('year')->take(6)->get();
        });
        $testimonials = Cache::remember('testimonials', 3600, function() {
            return Testimonial::get();
        });

        return view('web.project', compact('contacts','testimonials', 'projects', 'sosmeds'));
    }

    public function show($slug)
    {
        // Cache untuk kontak dan sosmed
        $contacts = Cache::remember('contacts', 3600, function () {
            return Contact::first();
        });

        $sosmeds = Cache::remember('mediasocials', 3600, function () {
            return MediaSocial::get();
        });

        // Cache untuk project detail berdasarkan slug
        $project = Cache::remember("project_{$slug}", 3600, function () use ($slug) {
            return Project::with('images')
                ->where('slug', $slug)
                ->firstOrFail();
        });

        // Cache untuk project lain (menggunakan ID unik supaya tidak bentrok antar cache)
        $otherProjects = Cache::remember("other_projects_{$project->id}", 3600, function () use ($project) {
            return Project::where('id', '!=', $project->id)
                ->with('images')
                ->inRandomOrder()
                ->take(4)
                ->get();
        });

        return view('web.projectshow', compact('project', 'contacts', 'sosmeds', 'otherProjects'));
    }

}
