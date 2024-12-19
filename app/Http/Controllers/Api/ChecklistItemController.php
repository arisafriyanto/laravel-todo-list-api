<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ChecklistItemRequest;
use App\Models\Checklist;
use App\Models\ChecklistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChecklistItemController extends Controller
{
    private function findChecklist($checklistId)
    {
        return Checklist::where('id', $checklistId)
            ->where('user_id', auth()->id())
            ->first();
    }

    public function index($checklistId)
    {
        $checklist = $this->findChecklist($checklistId);
        if (!$checklist) {
            return response()->json([
                'success' => false,
                'errors' => 'Checklist not found'
            ], 404);
        }

        $items = $checklist->items;
        return response()->json([
            'success' => true,
            'data' => $items,
            'message' => 'Get checklist items success'
        ]);
    }

    public function store(ChecklistItemRequest $request, $checklistId)
    {
        $checklist = $this->findChecklist($checklistId);

        if (!$checklist) {
            return response()->json([
                'success' => false,
                'errors' => 'Checklist not found'
            ], 404);
        }

        $item = ChecklistItem::create([
            'checklist_id' => $checklistId,
            'item_name' => $request->itemName,
        ]);

        return response()->json([
            'success' => true,
            'data' => $item,
            'message' => 'Create new cheklist item success'
        ], 201);
    }

    public function show($checklistId, $checklistItemId)
    {
        $checklist = $this->findChecklist($checklistId);
        if (!$checklist) {
            return response()->json([
                'success' => false,
                'errors' => 'Checklist not found'
            ], 404);
        }

        $item = $checklist->items()->find($checklistItemId);
        if (!$item) {
            return response()->json([
                'success' => false,
                'errors' => 'Checklist item not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $item,
            'message' => 'Get checklist item success'
        ]);
    }

    public function update(Request $request, $checklistId, $checklistItemId)
    {
        $checklist = $this->findChecklist($checklistId);
        if (!$checklist) {
            return response()->json([
                'success' => false,
                'errors' => 'Checklist not found'
            ], 404);
        }

        $item = $checklist->items()->find($checklistItemId);
        if (!$item) {
            return response()->json([
                'success' => false,
                'errors' => 'Checklist item not found'
            ], 404);
        }

        if ($request->itemName) {
            $validator = Validator::make($request->all(), [
                'itemName' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 400);
            }

            $item->item_name = $request->itemName;
        } else {
            $item->status = 1;
        }

        $item->save();

        return response()->json([
            'success' => true,
            'data' => $item,
            'message' => 'Update checklist item success'
        ], 200);
    }

    public function destroy($checklistId, $checklistItemId)
    {
        $checklist = $this->findChecklist($checklistId);
        if (!$checklist) {
            return response()->json([
                'success' => false,
                'errors' => 'Checklist not found'
            ], 404);
        }

        $item = $checklist->items()->find($checklistItemId);
        if (!$item) {
            return response()->json([
                'success' => false,
                'errors' => 'Checklist item not found'
            ], 404);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'data' => [],
            'message' => 'Delete checklist item success'
        ], 200);
    }
}
