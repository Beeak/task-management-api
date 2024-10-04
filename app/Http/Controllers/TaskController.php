<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'due_date' => 'required|date',
            'priority' => 'required|integer',
            'status' => 'required|string'
        ]);

        $task = Task::create($validated);

        $task->users()->attach($validated['user_id']);

        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        /**
         * Updates the specified task with the validated request data.
         *
         * The request data is validated to ensure that the fields are of the correct type and format.
         * If a 'user_id' is provided and exists in the 'users' table, the user is associated with the task.
         * The task is then updated with the validated data.
         *
         * @param \Illuminate\Http\Request $request The incoming request containing the task data.
         * @param \App\Models\Task $task The task model instance to be updated.
         * @return \Illuminate\Http\JsonResponse A JSON response containing a success message and the updated task with associated users.
         *
         * @throws \Illuminate\Validation\ValidationException If the validation fails.
         * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the user specified by 'user_id' does not exist.
         */
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'due_date' => 'sometimes|date',
            'priority' => 'sometimes|in:low,medium,high',
            'status' => 'sometimes|in:pending,in_progress,completed',
        ]);

        if (isset($validated['user_id'])) {
            $user = User::findOrFail($validated['user_id']);
            $task->users()->syncWithoutDetaching([$user->id]);
        }

        $task->update($validated);

        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $task->load('users')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
