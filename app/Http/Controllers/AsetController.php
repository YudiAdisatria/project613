<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Requests\AsetRequest;

class AsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aset = Aset::with(['kategori'])->paginate(15);
        // return $aset[0];
        return view('asets.index', [
            'aset' => $aset
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = Kategori::get();
        return view('asets.create', [
            'kategori' => $kategori
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AsetRequest $request)
    {
        $data = $request->all();

        if($request->file('foto_aset')){
            $data['foto_aset'] = $request->file('foto_aset')->store('assets/aset', 'public');
        }
        Aset::create($data);

        return redirect()->route('asets.index');
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
        $edit = Aset::where('id_aset', '=', $id)->get();
        $kategori = Kategori::get();

        return view('asets.edit', [
            'item' => $edit[0],
            'kategori' => $kategori
        ]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
