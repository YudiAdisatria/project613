<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request('search')){
            $history = History::with(['user'])
                ->where('id_history', 'like', '%'. request('search') . '%')
                ->orWhere('id_pemindah', 'like', '%'. request('search') . '%')
                ->orWhere('id_aset', 'like', '%'. request('search') . '%')
                ->orWhere('lokasi_lama', 'like', '%'. request('search') . '%')
                ->orWhere('lokasi_baru', 'like', '%'. request('search') . '%')
                ->orWhere('jenis_pindah', 'like', '%'. request('search') . '%')
                ->paginate(15);
            
            return view('asets.history', [
                'items' => $history
            ]);
        }

        $history = History::with(['user'])->paginate(15);
        // return $history[0];
        return view('asets.history', [
            'items' => $history
        ]);
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
        //
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
