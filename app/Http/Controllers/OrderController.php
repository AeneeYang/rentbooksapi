<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

            $order = Order::create($request -> all());
            $order = $order -> refresh();

            // 刪除不需要的資訊
            unset($order['created_at']);
            unset($order['updated_at']);

            $order['status'] = true;
            return response($order, Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            
            // 錯誤資訊
            $info = '發生錯誤';

            $order = array('info' => $info, 'status' => false);
            return response($order, Response::HTTP_CREATED);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        try {

            $order -> update($request -> all());
            $order['status'] = true;

            // 刪除不需要的資訊
            unset($order['created_at']);
            unset($order['updated_at']);

            return response($order, Response::HTTP_OK);

        } catch (\Throwable $th) {
            
            // 錯誤資訊
            $info = '發生錯誤';

            $order = array('info' => $info, 'status' => false);
            return response($order, Response::HTTP_CREATED);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
