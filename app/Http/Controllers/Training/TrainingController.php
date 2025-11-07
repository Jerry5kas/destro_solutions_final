<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use App\Models\ContentItem;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function index()
    {
        $trainings = ContentItem::where('type', 'training')
            ->where('status', 'active')
            ->where('is_enrollable', true)
            ->orderBy('start_date')
            ->get();

        return view('training.index', compact('trainings'));
    }

    public function show(string $slug)
    {
        $training = ContentItem::with(['category', 'enrollments'])
            ->where('type', 'training')
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        return view('training.show', compact('training'));
    }
}
