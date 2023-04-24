<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $tasks = $this->task->admin();
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
        //
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
