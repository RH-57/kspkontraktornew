<?php

namespace App\Http\Controllers\Web;

use App\Models\Contact;
use App\Models\MediaSocial;
use App\Models\Procedure;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ServiceController
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
            return Project::with('images')->latest()->take(6)->get();
        });
        $procedures = Cache::remember('procedures', 3600, function() {
            return Procedure::orderBy('no')->get();
        });

        return view('web.service', compact('contacts','services', 'projects', 'sosmeds', 'procedures'));
    }

    public function show($slug)
    {
        $contacts = Cache::remember('contacts', 3600, function () {
            return Contact::first();
        });

        $sosmeds = Cache::remember('mediasocials', 3600, function () {
            return MediaSocial::get();
        });

        // Cache untuk service detail berdasarkan slug
        $service = Cache::remember("service_{$slug}", 3600, function () use ($slug) {
            return Service::where('slug', $slug)
                ->where('status', '1')
                ->firstOrFail();
        });

        // Cache untuk related services (kita bisa gunakan ID service untuk membedakan cache)
        $relatedServices = Cache::remember("related_services_{$service->id}", 3600, function () use ($service) {
            return Service::where('status', '1')
                ->where('id', '!=', $service->id)
                ->take(3)
                ->get();
        });

        return view('web.service-detail', compact('service', 'contacts', 'sosmeds', 'relatedServices'));
    }

}
