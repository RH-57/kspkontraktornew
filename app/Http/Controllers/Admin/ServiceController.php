<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;


class ServiceController extends Controller
{
    public function index() {
        $services = Cache::remember('services', 3600, function() {
            return Service::withoutTrashed()->get();
        });
        return view('admin.services.index', compact('services'));
    }

    public function create() {
        return view('admin.services.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title'             => 'required|string|max:255',
            'slug'              => 'nullable|string|max:255|unique:services,slug',
            'short_description' => 'required|string',
            'description'       => 'required|string',
            'icon'              => 'nullable|string|max:50',
            'image'             => 'required|image|mimes:jpeg,jpg,png,webp|max:4096',
            'status'            => 'required|in:0,1',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string',
            'meta_keyword'      => 'nullable|string|max:255',
            'meta_image'        => 'nullable|image|mimes:jpeg,jpg,png,webp|max:4096',
            'canonical_url'     => 'nullable|url|max:255',
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $manager = new ImageManager(new Driver());
            $file = $request->file('image');
            $image = $manager->read($file->getPathname());
            $encoded = $image->encode(new WebpEncoder(quality:75));
            $filename = uniqid() . '.webp';
            $path = 'services/images/' . $filename;

            Storage::disk('public')->put($path, (string) $encoded);
            $imagePath = $path;
        }

        $metaImagePath = null;
        if ($request->hasFile('meta_image')) {
            $manager = new ImageManager(new Driver());
            $file = $request->file('meta_image');
            $image = $manager->read($file->getPathname());
            $encoded = $image->encode(new WebpEncoder(quality:75));
            $filename = uniqid() . '.webp';
            $path = 'services/meta/' . $filename;

            Storage::disk('public')->put($path, (string) $encoded);
            $metaImagePath = $path;
        }

        $canonicalUrl = $request->canonical_url ? $request->canonical_url : url('services', $slug);

        Service::create([
            'title'             => $request->title,
            'slug'              => $slug,
            'short_description' => $request->short_description,
            'description'       => $request->description,
            'icon'              => $request->icon,
            'image'             => $imagePath,
            'status'            => $request->status,
            'meta_title'        => $request->meta_title,
            'meta_keyword'      => $request->meta_keyword,
            'meta_description'  => $request->meta_description,
            'meta_image'        => $metaImagePath,
            'canonical_url'     => $canonicalUrl,
        ]);

        Cache::forget('services');

        return redirect()->route('services.index')->with(['success' => 'Service created successfully']);
    }

    public function show($slug) {
        $service = Service::where('slug', $slug)->firstOrFail();
        return view('admin.services.show', compact('service'));
    }

    public function edit($slug) {
        $service = Service::where('slug', $slug)->firstOrFail();
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, $slug) {
        $service = Service::where('slug', $slug)->firstOrFail();

        $request->validate([
            'title'             => 'required|string|max:255',
            'slug'              => 'nullable|string|max:255|unique:services,slug,' . $service->id,
            'short_description' => 'required|string',
            'description'       => 'required|string',
            'icon'              => 'nullable|string|max:50',
            'image'             => 'nullable|image|mimes:jpeg,jpg,png,webp|max:4096',
            'status'            => 'required|in:0,1',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string',
            'meta_keyword'      => 'nullable|string|max:255',
            'meta_image'        => 'nullable|image|mimes:jpeg,jpg,png,webp|max:4096',
            'canonical_url'     => 'nullable|url|max:255',
        ]);

        $slugNew = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);
        if (Service::where('slug', $slugNew)->where('id', '!=', $service->id)->exists()) {
            $slugNew .= '-' . time();
        }

        $manager = new ImageManager(new Driver());
        $imagePath = $service->image;
        if ($request->hasFile('image')) {
            if ($service->image && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }

            $file = $request->file('image');
            $image = $manager->read($file->getPathname());
            if ($image->width() > 1200) {
                $image->scaleDown(width: 1200);
            }

            $encoded = $image->encode(new WebpEncoder(quality:70));
            $filename = uniqid() . '.webp';
            $path = 'services/images/' . $filename;
            Storage::disk('public')->put($path, (string) $encoded);
            $imagePath = $path;
        }

        // === Update & Compress Meta Image ===
        $metaImagePath = $service->meta_image;
        if ($request->hasFile('meta_image')) {
            if ($service->meta_image && Storage::disk('public')->exists($service->meta_image)) {
                Storage::disk('public')->delete($service->meta_image);
            }

            $file = $request->file('meta_image');
            $image = $manager->read($file->getPathname());
            if ($image->width() > 1200) {
                $image->scaleDown(width: 1200);
            }

            $encoded = $image->encode(new WebpEncoder(quality:70));
            $filename = uniqid() . '.webp';
            $path = 'services/meta/' . $filename;
            Storage::disk('public')->put($path, (string) $encoded);
            $metaImagePath = $path;
        }

        $canonicalUrl = $request->canonical_url ? $request->canonical_url : url('services', $slug);

        $service->update([
            'title'             => $request->title,
            'slug'              => $slugNew,
            'short_description' => $request->short_description,
            'description'       => $request->description,
            'icon'              => $request->icon,
            'image'             => $imagePath,
            'status'            => $request->status,
            'meta_title'        => $request->meta_title,
            'meta_keyword'      => $request->meta_keyword,
            'meta_description'  => $request->meta_description,
            'meta_image'        => $metaImagePath ?? $service->meta_image,
            'canonical_url'     => $canonicalUrl,
        ]);

        Cache::forget('services');

        return redirect()->route('services.index')->with(['success' => 'Service updated successfully']);
    }


    public function destroy($id) {
        $service = Service::findOrFail($id);
        $service->delete();

        Cache::forget('services');

        return redirect()->route('services.index')->with('success', 'Service Deleted Successfully');
    }

}
