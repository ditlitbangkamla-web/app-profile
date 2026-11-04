<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\QuestionStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\QuestionResource;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class QuestionController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min((int) $request->input('per_page', 10), 50);

        $questions = Question::query()
            ->answered()
            ->with([
                'topic',
                'answers' => fn ($query) => $query->published()->with('user'),
            ])
            ->whereHas('answers', fn ($query) => $query->published())
            ->when($request->filled('topic'), function ($query) use ($request) {
                $query->whereHas('topic', function ($q) use ($request) {
                    $q->where('slug', $request->input('topic'));
                });
            })
            ->latest()
            ->paginate($perPage);

        return QuestionResource::collection($questions);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'topic_id' => ['nullable', 'exists:question_topics,id'],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'min:10'],
        ]);

        $validated['ip_address'] = $request->ip();
        $validated['status'] = QuestionStatus::Pending;

        $question = Question::create($validated);

        return response()->json([
            'message' => 'Pertanyaan Anda berhasil dikirimkan dan akan segera ditindaklanjuti.',
            'data' => new QuestionResource($question->load('topic')),
        ], 201);
    }
}
