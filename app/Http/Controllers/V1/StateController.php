<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\State;
use App\Http\Requests\StateRequest;
use App\traits\ApiResponse;
class StateController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $state=State::get();
            $responseData=$state->map(function($state){
                return[
                    "id"=>$state->id,
                    "state_name"=>$state->state_name
                ];
            });
            return $this->successResponse($responseData,"State Fetched...");

        }catch(Exception $ex){
            return $this->errorResponse($ex->getMessage(),"Exception Occured");
        }
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
    public function store(StateRequest $request)
    {
       try {
         $validation=$request->validated();
        $other=$request->except(array_keys($validation));
        $data=array_merge($validation,$other);
        $state=State::create($data);

        $responseData=[
            'id'=> $state->id,
            'state_name'=> $state->state_name,

        ];

        return $this->successResponse($responseData,"State Creatd Successfully");   

       }catch(Exception $ex)
       {
        return $this->errorResponse($ex->getMessage(),"Exception Occured");
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
    public function update(StateRequest $request, string $id)
    {
        try {
            $state=State::find($id);

            $validation=$request->validated();
            $other=$request->except(array_keys($validation));
            $data=array_merge($validation,$other);
            $state->update($data);

            $responseData=[
                "id"=> $state->id, 
                "state_name"=> $state->state_name
            ];

            return $this->successResponse($responseData,"State Updated Successfully");
        }catch(Exception $ex)
        {
            return $this->errorResponse($ex->getMessage(),"Exception Occured");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $state=State::find($id);
            if($state)
            {
                $state->status=0;
                $state->save();
                return $this->successResponse("State Removed Successfully","State Removed");

            }
        }catch(Exception $ex)
        {
            return $this->errorResponse($ex->getMessage(),"Exception OCcured");
        }
    }
}
