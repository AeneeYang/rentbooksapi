<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {

            $phone = $request -> phone;
            $user = User::where('phone','=',$phone) -> first(['id', 'name', 'phone', 'balance']);
            
            if ($user != null)
                $user['status'] = true;

            elseif($phone==null)
                $user = array('info' => '欄位不能為空白', 'status' => false);

            else
                $user = array('info' => '顧客未加入會員', 'status' => false);

            return response($user, Response::HTTP_OK);

        } catch (\Throwable $th) {

            $user = array('info' => '發生錯誤', 'status' => false);
            return response($user, Response::HTTP_OK);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request = User::create($request -> all());

            if(is_numeric($request->phone)==true){
                if(strlen($request->phone) == 10 ){      
                    $user = $request -> refresh();
                    $user['status'] = true;
                }
                else
                $user = array('info' => '電話號碼不正確', 'status' => false);
            }
            else
                $user = array('info' => '電話號碼只能有數字', 'status' => false);

            // 刪除不需要的資訊
            unset($user['created_at']);
            unset($user['updated_at']);
            return response($user, Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            // 錯誤資訊
            $error_info = ($th -> errorInfo)[2];
            if (strpos($error_info, 'Duplicate entry') !== false)
                $info = '會員已註冊過';
            else
                $info = '發生錯誤';
            
            $user = array('info' => $info, 'status' => false);
            return response($user, Response::HTTP_CREATED);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {   
        try {
            // 刪除不需要的資訊
            unset($user['created_at']);
            unset($user['updated_at']);

            $user['status'] = true;
            return response($user, Response::HTTP_OK);

        } catch (\Throwable $th) {
            // 錯誤資訊
            $info = '發生錯誤';
            $user = array('info' => $info, 'status' => false);
            return response($user, Response::HTTP_CREATED);
        }
       

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {   
        try {
            //只取phone,name
            if($request->name == null||$request->phone == null)
                $user = array('info'=>'不能為空值');
            elseif(is_numeric($request->phone)==true){
                if(strlen($request->phone) == 10 )
                    $user -> update($request->only(['phone','name']));
                    // 刪除不需要的資訊
                    unset($user['created_at']);
                    unset($user['updated_at']);
                    $user['status'] = true;
            }
            else{
                $user = array('info'=>'電話號碼錯誤');
                $user['status'] = false;
            }
               
            return response($user, Response::HTTP_OK);

        } catch (\Throwable $th) {
            // 錯誤資訊
            $error_info = ($th -> errorInfo)[2];
            
            if (strpos($error_info, 'Duplicate entry') !== false)
                $info = '會員已註冊過';
            else
                $info = '發生錯誤';
            
            $user = array('info' => $info, 'status' => false);

            return response($user, Response::HTTP_CREATED);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
       //  
    }
}
