<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
use App\Models\Book;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            
            //查詢書
            $column = $request -> column;
            $data = $request -> data;
            $book = Book::where($column,'like','%'.$data.'%') -> get();
            
            return response($book, Response::HTTP_OK);
                
        }catch(\Throwable $th){
             // 錯誤資訊
             $error_info = ($th -> errorInfo)[2];
             
             $info = '發生錯誤';
             
             $book = array('info' => $info, 'status' => 'error');
             
             return response($book, Response::HTTP_OK);
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
        //新增資料
        try{
            if(is_numeric($request->barcode)!=true)
                $book = array('info' => '條碼只能為數字', 'status' => false);
            else
            {
                $request = Book::create($request->all());
                $book = $request ->refresh();
                // 刪除不需要的資訊
                unset($book['created_at']);
                unset($book['updated_at']);
                $book['status'] = true;
            }
            return response($book, Response::HTTP_CREATED);    
        }catch(\Throwable $th){
             // 錯誤資訊
             $error_info = ($th -> errorInfo)[2];
             if (strpos($error_info, 'Duplicate entry') !== false)
                 $info = '書已存在';
             else
                 $info = '發生錯誤';
             
             $book = array('info' => $info, 'status' => 'error');
             
             return response($book, Response::HTTP_CREATED);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //查詢
        try {
            return response($book, Response::HTTP_OK);

            $user['status'] = true;
            return response($user, Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            
            // 錯誤資訊
            $error_info = ($th -> errorInfo)[2];
            $info = '查無資料';    
            $user = array('info' => $info, 'status' => 'error');
            
            return response($user, Response::HTTP_CREATED);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        //更新資料
        try{
            if(is_numeric($request->barcode)!=true)
                $book = array('info' => '條碼只能為數字', 'status' => false);
            else{
                $book -> update($request->all());
                $book['status'] = true;
            }
            return response($book, Response::HTTP_OK);
        }catch(\Throwable $th){
            // 錯誤資訊
            $error_info = ($th -> errorInfo)[2];

            if (strpos($error_info, 'Duplicate entry') !== false)
                $info = '書名重複';
            else
                $info = '發生錯誤';
            
            $book = array('info' => $info, 'status' => 'error');
            
            return response($book, Response::HTTP_CREATED);
       }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //刪除資料
        $book -> delete();
        $book = array('info' => '刪除成功', 'status' => true);
        return response($book, Response::HTTP_OK);
        
    }
}
