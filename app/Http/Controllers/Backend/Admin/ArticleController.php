<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Admin\ArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Radio;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->expectsJson()) return $this->jsonResponse($request);

        return view('backend.admin.articles.index');
    }

    private function jsonResponse(Request $request)
    {
        $semesterId = (int) $request->get('semester_id');
        $level = $request->get('level');
        $weekNumber = $request->get('week_number');
        $radioId = $request->get('radio_id');

        $query = Article::with(['radio:id,semester_id,level,subject', 'author:id,name'])->latest();

        if ($radioId) {
            $query->whereRadioId($radioId);
        } else {
            $query->whereHas(
                'radio',
                fn ($q) =>
                $q->when($semesterId, fn ($q2) => $q2->where('semester_id', $semesterId))
                    ->when($level, fn ($q2) => $q2->where('level', $level))
                    ->when($weekNumber, fn ($q2) => $q2->where('week_number', $weekNumber))
            );
        }

        $articles = $query->paginate(15)->withQueryString();

        return ArticleResource::collection($articles);
    }

    public function store(ArticleRequest $request)
    {
        //
        $articleData = $request->only(['radio_id', 'title','attachment']);

        //
        $article = auth()->user()->articles()->create($articleData);
        $article->refresh();

        $article->load(['radio:id,semester_id,level,subject,week_number', 'author:id,name']);

        return response()->json([
            'status' => 200,
            'message' => __('Data created successfully'),
            'data' => new ArticleResource($article)
        ]);
    }

    public function show(Article $article)
    {
        abort_if(!request()->expectsJson(), 404);

        $article->load(['radio:id,semester_id,level,subject,week_number', 'author:id,name']);

        return response()->json([
            'status' => 200,
            'data' => new ArticleResource($article)
        ]);
    }

    public function update(ArticleRequest $request, Article $article)
    {
        //
        $articleData = $request->only(['radio_id', 'title','attachment']);

        //
        $article->radio_id = $articleData['radio_id'];
        $article->title = $articleData['title'];
        $article->attachment = $articleData['attachment'];
        $article->save();

        $article->load(['radio:id,semester_id,level,subject,week_number', 'author:id,name']);

        return response()->json([
            'status' => 200,
            'message' => __('Data updated successfully'),
            'data' => new ArticleResource($article)
        ]);
    }

    public function getRadios(Request $request)
    {
        abort_if(!request()->expectsJson(), 404);

        [
            'semester_id' => $semesterId,
            'level' => $level,
        ] = $request->validate([
            'semester_id' => 'required|exists:semesters,id',
            'level'     => 'required|in:primary,middle,secondary',
            'week_number' => 'nullable|integer'
        ]);

        $weekNumber = $request->get('week_number');

        $query = Radio::latest('radio_date');

        $query->where('semester_id', $semesterId)
            ->where('level', $level)
            ->when($weekNumber, fn ($q2) => $q2->where('week_number', $weekNumber));

        $radios = $query->get(['id', 'subject'])->pluck('subject', 'id')->toArray();

        return response()->json([
            'status' => 200,
            'data' => $radios
        ]);
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return response()->json([
            'status' => 200,
            'message' => __('Data deleted successfully')
        ]);
    }
}
