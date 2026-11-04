<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min((int) $request->input('per_page', 10), 50);

        $posts = Post::query()
            ->published()
            ->with(['category', 'user'])
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('category', function ($q) use ($request) {
                    $q->where('slug', $request->input('category'));
                });
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('summary', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->when($request->boolean('featured'), function ($query) {
                $query->featured();
            })
            ->latest('published_at')
            ->paginate($perPage);

        return PostResource::collection($posts);
    }

    public function show(string $slug): JsonResponse|PostResource
    {
        $post = Post::query()
            ->published()
            ->with(['category', 'user'])
            ->where('slug', $slug)
            ->firstOrFail();

        $post->increment('view_count');

        return new PostResource($post);
    }
}
