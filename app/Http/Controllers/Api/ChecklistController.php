<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ChecklistRequest;
use App\Models\Checklist;

class ChecklistController extends Controller
{
    public function index()
    {
        $checklists = Checklist::where('user_id', auth()->id())->get();
        return response()->json([
            'success' => true,
            'data' => $checklists,
            'message' => 'Get checklist success'
        ]);
    }

    public function store(ChecklistRequest $request)
    {
        $checklist = Checklist::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'data' => $checklist,
            'message' => 'Create new checklist success'
        ], 201);
    }

    public function destroy($checklistId)
    {
        $checklist = Checklist::whereId($checklistId)
            ->where('user_id', auth()->id())
            ->first();

        if (!$checklist) {
            return response()->json([
                'success' => false,
                'errors' => 'Checklist not found'
            ], 404);
        }

        $checklist->delete();
        return response()->json([
            'success' => true,
            'data' => [],
            'message' => 'Delete checklist success'
        ], 200);
    }
}
