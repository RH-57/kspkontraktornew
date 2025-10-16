<?php

namespace App\Http\Controllers\Admin;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class TestimonialController
{
    public function index() {
        $testimonials = Testimonial::paginate(10);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create() {
        return view('admin.testimonials.create');
    }

    public function store(Request $request) {
        $request->validate([
            'client_name'       => 'required|string|max:35',
            'project_name'      => 'required|string|max:100',
            'description'       => 'required|string',
            'image'             => 'required|image|mimes:jpeg,jpg,png,webp|max:4096',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $manager = new ImageManager(new Driver());
            $file = $request->file('image');
            $image = $manager->read($file->getPathname());

            // Resize to max 150x150, maintaining aspect ratio and cropping if needed
            $image->cover(150, 150); // atau ->scaleDown(150); jika ingin tanpa crop

            // Encode to WebP with lower quality
            $encoded = $image->encode(new WebpEncoder(quality: 65));

            $filename = uniqid() . '.webp';
            $path = 'testimonials/images/' . $filename;

            Storage::disk('public')->put($path, (string) $encoded);
            $imagePath = $path;
        }


        Testimonial::create([
            'client_name'       => $request->client_name,
            'project_name'      => $request->project_name,
            'description'       => $request->description,
            'image'             => $imagePath,
        ]);

        return redirect()->route('testimonials.index')->with('success', 'Testimonial Created Successfully');
    }

    public function edit($id) {
        $testimonial = Testimonial::findOrFail($id);

        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update (Request $request, $id) {
        $testimonial = Testimonial::where('id', $id)->firstOrFail();

        $request->validate([
            'client_name'       => 'required|string|max:35',
            'project_name'      => 'required|string|max:100',
            'description'       => 'required|string',
            'image'             => 'nullable|image|mimes:jpeg,jpg,png,webp|max:4096',
        ]);

        $imagePath = $testimonial->image;
        if ($request->hasFile('image')) {
            if ($testimonial->image && Storage::disk('public')->exists($testimonial->image)) {
                Storage::disk('public')->delete($testimonial->image);
            }

            $manager = new ImageManager(new Driver());
            $file = $request->file('image');
            $image = $manager->read($file->getPathname());

            // Resize to max 150x150, maintaining aspect ratio and cropping if needed
            $image->cover(150, 150); // atau ->scaleDown(150); jika ingin tanpa crop

            // Encode to WebP with lower quality
            $encoded = $image->encode(new WebpEncoder(quality: 65));

            $filename = uniqid() . '.webp';
            $path = 'testimonials/images/' . $filename;

            Storage::disk('public')->put($path, (string) $encoded);
            $imagePath = $path;
        }

        $testimonial->update([
            'client_name'       => $request->client_name,
            'project_name'      => $request->project_name,
            'description'       => $request->description,
            'image'             => $imagePath,
        ]);

        return redirect()->route('testimonials.edit', $id)->with('success', 'Testimonial Updated Successfully');
    }

    public function destroy($id) {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();

        return redirect()->route('testimonials.index')->with('success', 'Testimonial Deleted Successfully');
    }
}
