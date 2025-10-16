<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

class ProjectController extends Controller
{
    public function index() {
        $projects = Project::with('images')->latest()->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create() {
        return view('admin.projects.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name'              => 'required|string|max:100',
            'location'          => 'nullable|string|max:100',
            'description'       => 'required|string',
            'year'              => 'required|digits:4|integer',
            'cover_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'images'            => 'required|array',
            'images.*'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string',
            'meta_keyword'      => 'nullable|string|max:255',
            'canonical_url'     => 'nullable|url|max:255',
        ]);

        $manager = new ImageManager(new Driver());

        // === Slug Unik ===
        $baseSlug = Str::slug($request->name);
        $slug = $baseSlug;
        $counter = 1;
        while (Project::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . str_pad($counter, 2, '0', STR_PAD_LEFT);
            $counter++;
        }

        $canonicalUrl = $request->canonical_url ?: url('projects/' . $slug);

        // === Upload & Compress Cover Image ===
        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $image = $manager->read($file->getPathname());

            // Resize agar tidak terlalu besar
            if ($image->width() > 1600) {
                $image->scaleDown(width: 1600);
            }

            $encoded = $image->encode(new WebpEncoder(quality:70));
            $filename = uniqid() . '.webp';
            $path = 'projects/cover/' . $filename;
            Storage::disk('public')->put($path, (string) $encoded);
            $coverPath = $path;
        }

        // === Simpan Project ===
        $project = Project::create([
            'name'              => $request->name,
            'slug'              => $slug,
            'location'          => $request->location,
            'description'       => $request->description,
            'year'              => $request->year,
            'cover_image'       => $coverPath,
            'meta_title'        => $request->meta_title,
            'meta_description'  => $request->meta_description,
            'meta_keyword'      => $request->meta_keyword,
            'canonical_url'     => $canonicalUrl,
        ]);

        // === Upload & Compress Semua Gambar ===
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $image = $manager->read($file->getPathname());

                // Resize jika terlalu besar (contoh max 1200px)
                if ($image->width() > 1200) {
                    $image->scaleDown(width: 1200);
                }

                // Encode ke WebP
                $encoded = $image->encode(new WebpEncoder(quality:70));

                $filename = uniqid() . '.webp';
                $path = 'projects/images/' . $filename;
                Storage::disk('public')->put($path, (string) $encoded);

                ProjectImage::create([
                    'project_id'    => $project->id,
                    'image'         => $path
                ]);
            }
        }

        return redirect()->route('projects.index')->with('success', 'Project Created Successfully');
    }

    public function show($slug) {
        $project = Project::with('images')->where('slug', $slug)->firstOrFail();
        return view('admin.projects.show', compact('project'));
    }

    public function edit($slug) {
        $project = Project::where('slug', $slug)->with('images')->firstOrFail();
        return view('admin.projects.edit', compact('project'));
    }

    public function deleteImage($id) {
        $image = ProjectImage::findOrFail($id);

        if ($image->image && Storage::disk('public')->exists($image->image)) {
            Storage::disk('public')->delete($image->image);
        }

        $image->delete();
        return redirect()->back()->with('success', 'Image deleted successfully!');
    }

    public function update(Request $request, $slug) {
        $project = Project::where('slug', $slug)->firstOrFail();

        $request->validate([
            'name'              => 'required|string|max:100',
            'location'          => 'nullable|string|max:100',
            'description'       => 'required|string',
            'year'              => 'required|digits:4|integer',
            'cover_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'images.*'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string',
            'meta_keyword'      => 'nullable|string|max:255',
            'canonical_url'     => 'nullable|url|max:255',
        ]);

        $manager = new ImageManager(new Driver());

        // === Slug Unik Saat Update ===
        $baseSlug = Str::slug($request->name);
        $newSlug = $baseSlug;
        $counter = 1;
        while (Project::where('slug', $newSlug)->where('id', '!=', $project->id)->exists()) {
            $newSlug = $baseSlug . '-' . str_pad($counter, 2, '0', STR_PAD_LEFT);
            $counter++;
        }
        $canonicalUrl = $request->canonical_url ?: url('projects/' . $newSlug);

        // === Update Cover Image ===
        if ($request->hasFile('cover_image')) {
            if ($project->cover_image && Storage::disk('public')->exists($project->cover_image)) {
                Storage::disk('public')->delete($project->cover_image);
            }

            $file = $request->file('cover_image');
            $image = $manager->read($file->getPathname());
            if ($image->width() > 1600) {
                $image->scaleDown(width: 1600);
            }
            $encoded = $image->encode(new WebpEncoder(quality:70));
            $filename = uniqid() . '.webp';
            $path = 'projects/cover/' . $filename;
            Storage::disk('public')->put($path, (string) $encoded);
            $project->cover_image = $path;
        }

        // === Update Data Project ===
        $project->update([
            'name'              => $request->name,
            'slug'              => $newSlug,
            'location'          => $request->location,
            'description'       => $request->description,
            'year'              => $request->year,
            'cover_image'       => $project->cover_image,
            'meta_title'        => $request->meta_title,
            'meta_description'  => $request->meta_description,
            'meta_keyword'      => $request->meta_keyword,
            'canonical_url'     => $canonicalUrl,
        ]);

        // === Upload Gambar Baru (Compress) ===
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $image = $manager->read($file->getPathname());
                if ($image->width() > 1200) {
                    $image->scaleDown(width: 1200);
                }

                $encoded = $image->encode(new WebpEncoder(quality:70));
                $filename = uniqid() . '.webp';
                $path = 'projects/images/' . $filename;
                Storage::disk('public')->put($path, (string) $encoded);

                ProjectImage::create([
                    'project_id' => $project->id,
                    'image'      => $path,
                ]);
            }
        }

        return redirect()->route('projects.show', $project->slug)
            ->with('success', 'Project updated successfully!');
    }

    public function destroy($id) {
        $project = Project::findOrFail($id);
        if ($project->cover_image && Storage::disk('public')->exists($project->cover_image)) {
            Storage::disk('public')->delete($project->cover_image);
        }

        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project Deleted Successfully');
    }
}
