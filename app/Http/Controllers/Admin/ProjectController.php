<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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

        $baseSlug = Str::slug($request->name);
        $slug = $baseSlug;

        // === CEK DUPLIKAT SLUG ===
        $counter = 1;
        while (Project::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . str_pad($counter, 2, '0', STR_PAD_LEFT);
            $counter++;
        }
        $canonicalUrl = $request->canonical_url ?: url('projects/' . $slug);
        $manager = new ImageManager(new Driver());

        // --- Upload & compress cover image ---
        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $image = $manager->read($request->file('cover_image')->getRealPath())
                            ->resize(1280, null, function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            });

            $coverFileName = 'projects/covers/' . uniqid() . '.webp';
            Storage::disk('public')->put($coverFileName, (string) $image->toWebp(80)); // quality 80%
            $coverPath = $coverFileName;
        }

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

         // --- Upload & compress gallery images ---
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $image = $manager->read($file->getRealPath())
                                ->resize(1280, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                    $constraint->upsize();
                                });

                $fileName = 'projects/' . uniqid() . '.webp';
                Storage::disk('public')->put($fileName, (string) $image->toWebp(80));

                ProjectImage::create([
                    'project_id' => $project->id,
                    'image'      => $fileName
                ]);
            }
        }

        return redirect()->route('projects.index')->with('success', 'Project Created Successfully');
    }

    public function show($slug) {
        $project = Project::with('images')->where('slug', $slug)->firstOrFail();
        return view('admin.projects.show', compact('project'));
    }

    public function edit($slug){
        $project = Project::where('slug', $slug)->with('images')->firstOrFail();
        return view('admin.projects.edit', compact('project'));
    }

    public function deleteImage($id)
    {
        $image = ProjectImage::findOrFail($id);

        // Hapus file dari storage
        if ($image->image && Storage::exists('public/' . $image->image)) {
            Storage::delete('public/' . $image->image);
        }

        // Hapus record di database
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

        $baseSlug = Str::slug($request->name);
        $newSlug = $baseSlug;

        // === CEK SLUG UNIK SAAT UPDATE ===
        $counter = 1;
        while (Project::where('slug', $newSlug)->where('id', '!=', $project->id)->exists()) {
            $newSlug = $baseSlug . '-' . str_pad($counter, 2, '0', STR_PAD_LEFT);
            $counter++;
        }
        $canonicalUrl = $request->canonical_url ?: url('projects/' . $newSlug);
        $manager = new ImageManager(new Driver());

         // === COVER IMAGE ===
        if ($request->hasFile('cover_image')) {
            // Hapus cover lama
            if ($project->cover_image && Storage::disk('public')->exists($project->cover_image)) {
                Storage::disk('public')->delete($project->cover_image);
            }

        // Baca & kompres cover baru
            $cover = $manager->read($request->file('cover_image')->getRealPath())
                            ->resize(1280, null, function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            });

            $coverFileName = 'projects/covers/' . uniqid() . '.webp';
            Storage::disk('public')->put($coverFileName, (string) $cover->toWebp(80)); // kualitas 80%

            $project->cover_image = $coverFileName;
        }

        // Update data project
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

         // === GALERI BARU ===
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $image = $manager->read($file->getRealPath())
                                ->resize(1280, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                    $constraint->upsize();
                                });

                $fileName = 'projects/' . uniqid() . '.webp';
                Storage::disk('public')->put($fileName, (string) $image->toWebp(80));

                ProjectImage::create([
                    'project_id' => $project->id,
                    'image'      => $fileName,
                ]);
            }
        }

        return redirect()->route('projects.show', $project->slug)
                        ->with('success', 'Project updated successfully!');
    }

    public function destroy($id) {
        $project = Project::findOrFail($id);
        // Hapus cover image juga // NEW
        if ($project->cover_image && Storage::exists('public/' . $project->cover_image)) {
            Storage::delete('public/' . $project->cover_image);
        }

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project Deleted Successfully');
    }
}
