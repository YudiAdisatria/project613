<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use App\Exports\HistoriesExport;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('manage-user')) {
            abort(403);
        }
        
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

    public function export() 
    {
        $tanggal = request('tanggal');
        date_default_timezone_set('Asia/Jakarta');
        return Excel::download(new HistoriesExport($tanggal), date('m-Y')." pindah jual".'.xlsx');
    }
}
