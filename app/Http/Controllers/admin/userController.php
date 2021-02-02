<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\admin\userRequest;
use Illuminate\Support\Str;
use App\Models\user;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item = user::orderBy('created_at','DESC')->get();

        return view('pages.admin.user.index',[
            'items' => $item
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(userRequest $request)
    {
        $data = $request->all();

        $data['password'] = bcrypt($request->password);
        
        user::create($data);

        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = user::findorfail($id);

        return view('pages.admin.user.edit',[
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(userRequest $request, $id)
    {
        $data = $request->all();

        $item = user::findorfail($id);

        if($request->password){
            $data['password'] = bcrypt($request->password);
        }
        else{
            unset($data['password']);
        }

        $item->update($data);

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = user::findorFail($id);
        $item->delete();

        return redirect()->route('user.index');
    }
}
