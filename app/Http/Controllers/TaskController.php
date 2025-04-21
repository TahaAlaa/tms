<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;
use App\Services\ApiResponseService;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class TaskController extends Controller
{

    protected $responseService;

    public function __construct(ApiResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    //
    public function index(){
        try {
            // $tasks=Task::all();
            $tasks = Task::where('user_id', auth()->id())->get();
            return $this->responseService->sendResponse($tasks, 'Task retrived successfully!',200);
        }catch (\Exception $e) {
            // Handle any other unexpected errors
            return $this->responseService->sendError('Something went wrong!',$e->getMessage(),500);
        }
        
    }

    public function store(Request $request){

        try {
            $request['user_id'] = auth()->id();  // Assign a static user_id, for example
            // Validate the incoming data
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'description' => 'required',
                'priority' => 'required',
            ]);
            $request['status']='status';

            if ($validator->fails()) {
                return $this->responseService->sendError('Validation failed!',$validator->errors(),422);
            }
    
            // Create the task
            $task = Task::create($request->only(['user_id', 'title', 'description', 'priority']));
    
            // // Return a success response
            return $this->responseService->sendResponse($task, 'Task Created successfully!',201);
    
        }catch (\Exception $e) {
            // Handle any other unexpected errors
            return $this->responseService->sendError('Something went wrong!',$e->getMessage(),500);
        }

    }

    public function update(Request $request,Task $task){

        try {
            $task->where('user_id', auth()->id())->update($request->only(['priority','status']));
            return $this->responseService->sendResponse($task, 'Task Updated successfully!',200);
        }catch (ModelNotFoundException $e) {
            // Handle the case when the task is not found
            return $this->responseService->sendError('Task not found!', [], 404);
        }catch (\Exception $e) {
            // Handle any other unexpected errors
            return $this->responseService->sendError('Something went wrong!',$e->getMessage(),500);
        }
        

    }

    public function delete(Task $task){

        try {
            $task->where('user_id', auth()->id())->delete();
            return $this->responseService->sendResponse([], 'Task Deleted successfully!',200);
        }catch (\Exception $e) {
            // Handle any other unexpected errors
            return $this->responseService->sendError('Something went wrong!',$e->getMessage(),500);
        }

    }
}
