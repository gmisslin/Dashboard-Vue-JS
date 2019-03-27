<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Flat;


class FlatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $flats = Flat::all();
      return $flats;
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
        $form = $request->form;
        $flat = new Flat();
        $flat->token = str_random(32);
        $flat->address = $form['address'];
        $flat->name = $form['name'];
        $flat->postal_code = $form['postalCode'];
        $flat->city = $form['city'];
        $flat->rent = $form['rent'];
        $flat->save();

        return 'fine';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $flat = Flat::where('token',$token)->first();
      return $flat;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $flat = Flat::where('token',$token)->first();
      $form = $request->form;
      $flat->address = $form['address'];
      $flat->name = $form['name'];
      $flat->postal_code = $form['postalCode'];
      $flat->city = $form['city'];
      $flat->rent = $form['rent'];
      $flat->save();

      return 'fine';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $flat = Flat::where('token',$token)->first();
        $flat->delete();

        return 'fine';
    }
}
