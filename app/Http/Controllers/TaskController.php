<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();
        return response()->json([
            'success' => true,
            'data' => $tasks,
            'message' => 'Tasks retrieved successfully'
        ], 200);
    }


    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:"pending", "in_progress", "completed"',
            'due_date' => 'nullable|date',
            'created_by' => 'required|string|max:255',
            'updated_by' => 'nullable|string|max:255'
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validatedData->errors(),
                'message' => 'Ur provided data is invalid'
            ], 422);
        }

        $task = $request->user()->tasks()->create($validatedData->validate());

        return response()->json([
            'success' => true,
            'data' => $task,
            'message' => 'Task created successfully'
        ], 201);
    }


    public function show(Task $task)
    {
        $task = Task::find($task->id);
        return response()->json([
            'success' => true,
            'data' => $task,
            'message' => 'Task retrieved successfully'
        ], 200);
    }

    public function update(Request $request, Task $task)
    {
        $validatedData = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending, in_progress, completed',
            'due_date' => 'nullable|date',
            'created_by' => 'required|string|max:255',
            'updated_by' => 'nullable|string|max:255'
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validatedData->errors(),
                'message' => 'Ur provided data is invalid'
            ], 422);
        }

        $updatedTask = $validatedData->validated();

        $task->update($updatedTask);

        return response()->json([
            'success' => true,
            'data' => $task,
            'message' => 'Task updated successfully'
        ], 200);
    }


    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully'
        ], 200);
    }
}
