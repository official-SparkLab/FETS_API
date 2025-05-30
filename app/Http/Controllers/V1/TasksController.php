<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tasks;
use App\Http\Requests\TasksRequest;
use App\traits\ApiResponse;
use Exception;
use Carbon\Carbon;
class TasksController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */


    public function getTaskToSuperAdmin(Request $request)
    {
        try {
            $startDate = $request->start_date ?? Carbon::today()->format('Y-m-d');
            $endDate = $request->end_date ?? $startDate;

            $companyId = $request->company_id;


            if (!$companyId) {
                return $this->errorResponse("Must Enter Company ID", "company_id is required");
            }

            // Query with both filters
            $tasks = Tasks::where('company_id', $companyId)
                ->where("status", '1')
                ->whereBetween('task_date', [$startDate, $endDate])
                ->get();

            // Response formatting
            $responseData = $tasks->map(function ($task) {
                return [
                    'task_id' => $task->id,
                    'title' => $task->title,
                    'description' => $task->description,
                    'priority' => $task->priority,
                    'task_date' => $task->task_date,
                    'due_date' => $task->due_date,
                    'attachment' => $task->attachment,
                    'recuring' => $task->recuring,
                    'assign_to' => $task->assign_to,
                    'department' => $task->department,
                ];
            });

            return $this->successResponse($responseData, "Tasks Fetched Successfully");

        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), "Error Occurred");
        }




    }

    public function getTaskToAdmin(Request $request)
    {
        try {
            // Validate user_id
            if (!$request->has('user_id')) {
                return $this->errorResponse("Must Enter User ID", "user_id is required");
            }

            $startDate = $request->start_date ?? Carbon::today()->format('Y-m-d');
            $endDate = $request->end_date ?? $startDate;
            $userId = $request->user_id;

            // Query with required user_id and date range
            $tasks = Tasks::where('created_by', $userId)
                ->where("status", '1')
                ->whereBetween('task_date', [$startDate, $endDate])
                ->get();

            $responseData = $tasks->map(function ($task) {
                return [
                    'task_id' => $task->id,
                    'title' => $task->title,
                    'description' => $task->description,
                    'priority' => $task->priority,
                    'task_date' => $task->task_date,
                    'due_date' => $task->due_date,
                    'attachment' => $task->attachment,
                    'recuring' => $task->recuring,
                    'assign_to' => $task->assign_to,
                    'department' => $task->department,
                ];
            });

            return $this->successResponse($responseData, "Tasks Fetched Successfully");

        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), "Error Occurred");
        }
    }


    /*public function getTaskToEmployee(Request $request)
    {
      try {
        // Validate user_id
        if (!$request->has('user_id')) {
            return $this->errorResponse("Must Enter User ID", "user_id is required");
        }

        $startDate = $request->start_date ?? Carbon::today()->format('Y-m-d');
        $endDate = $request->end_date ?? $startDate;
        $userId = $request->user_id;

        // Query with assign_to and date range
        $tasks = Tasks::where('assign_to', $userId)
                      ->whereBetween('task_date', [$startDate, $endDate])
                      ->get();

        $responseData = $tasks->map(function ($task) {
            return [
                'task_id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'priority' => $task->priority,
                'task_date' => $task->task_date,
                'due_date' => $task->due_date,
                'attachment' => $task->attachment,
                'recuring' => $task->recuring,
                'assign_to' => $task->assign_to,
                'department' => $task->department,
            ];
        });

        return $this->successResponse($responseData, "Tasks Fetched Successfully");

    } catch (Exception $e) {
        return $this->errorResponse($e->getMessage(), "Error Occurred");
    }

    }*/






    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TasksRequest $request)
    {
        try {
            $validate = $request->validated();
            $other = $request->except(array_keys($validate));
            $data = array_merge($validate, $other);
            // Handle file upload if attachment exists
            $uploadPath = 'Documents/Documents/';
            if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
                $file = $request->file('attachment');
                $uniqueFileName = time() . '_file_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path($uploadPath), $uniqueFileName);
                $data['attachment'] = $uploadPath . $uniqueFileName;
            }



            // Create the task
            $task = Tasks::create($data);

            $responseData = [
                'task_id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'priority' => $task->priority,
                'task_date' => $task->task_date,
                'due_date' => $task->due_date,
                'attachment' => $task->attachment,
                'recuring' => $task->recuring,

                'assign_to' => $task->assign_to,
                'department' => $task->department,


            ];

            return $this->successResponse($responseData, "Task Created Successfully");

        } catch (QueryException $qe) {
            return $this->errorResponse($qe->getMessage(), 'Database Error');
        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 'Exception Occurred');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TasksRequest $request, $id)
    {
        try {
            $task = Tasks::findOrFail($id);

            $validate = $request->validated();
            $other = $request->except(array_keys($validate));
            $data = array_merge($validate, $other);

            $uploadPath = 'Documents/Documents/';
            if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
                $file = $request->file('attachment');
                $uniqueFileName = time() . '_file_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path($uploadPath), $uniqueFileName);
                $data['attachment'] = $uploadPath . $uniqueFileName;


                if ($task->attachment && file_exists(public_path($task->attachment))) {
                    unlink(public_path($task->attachment));
                }
            }

            $task->update($data);

            $responseData = [
                'task_id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'priority' => $task->priority,
                'task_date' => $task->task_date,
                'due_date' => $task->due_date,
                'attachment' => $task->attachment,
                'recuring' => $task->recuring,
                'assign_to' => $task->assign_to,
                'department' => $task->department,
            ];

            return $this->successResponse($responseData, "Task Updated Successfully");


        } catch (QueryException $qe) {
            return $this->errorResponse($qe->getMessage(), 'Database Error');
        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 'Exception Occurred');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $task = Tasks::findOrFail($id);

            // Update only the status instead of deleting the record
            $task->status = '0';
            $task->save();

            return $this->successResponse(null, "Task marked as deleted successfully");


        } catch (QueryException $qe) {
            return $this->errorResponse($qe->getMessage(), 'Database Error');
        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 'Exception Occurred');
        }
    }

}
