<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Status;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * TransactionController constructor.
     */
    public function __construct()
    {
        $this->user = auth()->user();
        $this->task = new Task();
    }

    /**
     * @return JsonResponse
     */
    public function admin(){
        $tasks = $this->task->all();
        return response()->json([
            'data' => TaskResource::collection($tasks),
            'message' => 'Successfully loaded all Tasks for user: '.$this->user->name,
            'status' => 'Success'
        ]);
    }

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
        // get transaction creation data
        $task_input = $request->all();

        $validator = Validator::make($task_input, [
            'name' => 'required',
            'description' => 'required',
            'due_date' => 'required',
        ]);

        //check if request is valid
        if ($validator->fails()){
            return response()->json([
                'error' => [
                    'message' => $validator->messages()->first(),
                    'status' => 'Fail'
                ]
            ], 422);
        }

        // create task
        $task = new Task();
        $status = new Status();
        $task->name = $task_input['name'];
        $task->description = $task_input['description'];
        $task->due_date = $task_input['due_date'];
        $status->name = $task_input['description'];
        $status->save();
        $task->status_id = $status->id;        
        $task->save();

        return response()->json([
            'data' => TaskResource::collection($task),
            'message' => 'Successfully made transaction.',
            'status' => 'Success'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserTask $userTask)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserTask $userTask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserTask $userTask)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserTask $userTask)
    {
        //
    }
}
