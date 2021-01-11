<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $userTable;
    //Inisialisasi Model User
    function __construct()
    {
        $this->userTable = new User;
    }

    //Function for add data
    public function addData(Request $request)
    {
        $user = new User;
        $name = $request->name;
        $email = $request->email;

        $isSuccess = false;
        $message = "Failed Add Data";
        $data = null;
        $response_status = 200;
        $create = null;

        try {
            //Input data to table
            $create = $user->create(compact('name', 'email'));
        } catch (\Exception $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                $isSuccess = false;
                $message = "Email Already Registered";
                $data = null;
            }
        }
        if (!is_null($create)) {
            $isSuccess = true;
            $message = "Success Add Data";
            $data = $create;
        }
        return response()->json(compact('isSuccess', 'response_status', 'message'));
    }

    //Function for get view data
    public function getData(Request $request)
    {
        $data = $this->userTable::orderBy('id', 'DESC')->get();

        $isSuccess = true;
        $response_status = 200;
        $message = "Success Get Data";

        if (empty($data)) {
            $isSuccess = false;
            $response_status = 200;
            $message = "Not Found for view!";
        }
        return response()->json(compact('isSuccess', 'message', 'data'));
    }

    //Function search Data
    public function searchData(Request $request)
    {
        $keyword = $request->q;
        $data = $this->userTable->where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('email', 'LIKE', '%' . $keyword . '%')
            ->get();
        if (!empty($data)) {
            $isSuccess = true;
            $response_status = 200;
            $message = "Success Get Data";
        } else {
            $isSuccess = false;
            $response_status = 200;
            $message = "Failed Get Data";
        }
        $data = $data;

        return response()->json(compact('isSuccess', 'response_status', 'message', 'data'));
    }

    //Function Delete Data
    public function deleteData(Request $request)
    {
        $data = $this->userTable->find($request->id);

        $isSuccess = false;
        $message = "Failed Delete";
        $response_status = 404;

        if ($data->delete()) {
            $isSuccess = true;
            $response_status = 200;
            $message = "Success Delete Data";
        } else {
            $isSuccess = false;
            $response_status = 200;
            $message = "Failed Delete";
        }
        return response()->json(compact('isSuccess', 'message', 'response_status'));
    }

    //Function Edti Data
    public function editData(Request $request)
    {
        $data = $this->userTable->find($request->id);
        $isSuccess = false;
        $message = "Failed Update Data";
        $updateData = null;

        if (!empty($data)) {
            $name = $request->name;
            $email = $request->email;

            try {
                $updateData = $data->update(compact('name', 'email'));
            } catch (\Exception $e) {
                $errorCode = $e->errorInfo[1];

                if ($errorCode == 1062) {
                    $isSuccess = false;
                    $message = "Email Already, Try Again for other email";
                    $data = null;
                }
            }

            if ($updateData) {
                $isSuccess = true;
                $message = "Success Change";
                $data = $this->userTable->find($data->id);
            }
        }
        return response()->json(compact('isSuccess', 'message', 'data'));
    }
}
