<?php

namespace App\Http\Controllers;

use App\task;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            return response()->json(Task::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function store( Request $request)
    {
        $task = Task::create($request->all());

        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param task $task
     * @return task
     */
    public function show(Task $task)
    {
        return $task;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\task  $task
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\task $task
     * @return void
     */
    public function update(Request $request, task $task)
    {

        $task->update($request->all());

        return response()->json($task, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\task $task
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(task $task)
    {
        $task->delete();
        $task->success = 'cette tache a été supprimé !';
        return response()->json($task->success, 204);
    }
}
