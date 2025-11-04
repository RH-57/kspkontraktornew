<?php

namespace App\Http\Controllers\Web;

use App\Models\Contact;
use App\Models\MediaSocial;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ArticleController
{
    public function index() {
        // Cache kontak dan sosmed
        $contacts = Cache::remember('contacts', 3600, fn() => Contact::first());
        $sosmeds  = Cache::remember('mediasocials', 3600, fn() => MediaSocial::get());

        // Cache daftar artikel (gunakan pagination page agar cache tidak tertukar)
        $page = request()->get('page', 1);
        $posts = Cache::remember("posts_page_{$page}", 3600, function () {
            return Post::where('status', 'published')
                ->with('category')
                ->latest()
                ->paginate(6);
        });

        return view('web.article', compact('contacts', 'posts', 'sosmeds'));
    }

    public function show($slug) {
        // Cache kontak dan sosmed
        $contacts = Cache::remember('contacts', 3600, fn() => Contact::first());
        $sosmeds  = Cache::remember('mediasocials', 3600, fn() => MediaSocial::get());

        // Cache artikel utama
        $post = Cache::remember("post_{$slug}", 3600, function () use ($slug) {
            return Post::where('slug', $slug)
                ->where('status', 'published')
                ->with('category')
                ->firstOrFail();
        });

        // Cache artikel terkait berdasarkan kategori
        $relatedPosts = Cache::remember("related_posts_{$post->id}", 3600, function () use ($post) {
            return Post::where('status', 'published')
                ->where('post_category_id', $post->post_category_id)
                ->where('id', '!=', $post->id)
                ->latest()
                ->take(3)
                ->get();
        });

        return view('web.article-show', compact('contacts', 'sosmeds', 'post', 'relatedPosts'));
    }
}
