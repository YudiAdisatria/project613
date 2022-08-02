<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use App\Exports\RuanganExport;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\RuanganRequest;

class RuanganController extends Controller
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
            $ruangan = Ruangan::where('id_ruangan', 'like', '%'. request('search') . '%')
                ->orWhere('gedung', 'like', '%'. request('search') . '%')
                ->orWhere('ruangan', 'like', '%'. request('search') . '%')
                ->paginate(15);
            
            return view('ruangans.index', [
                'ruangan' => $ruangan
            ]);
        }

        $ruangan = Ruangan::paginate(15);

        return view('ruangans.index', [
            'ruangan' => $ruangan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ruangans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RuanganRequest $request)
    {
        $data = $request->all();
        
        Ruangan::create($data);

        return redirect()->route('ruangans.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ruangan = Ruangan::Where('gedung', 'like', '%'.$id.'%')
            ->orderBy('ruangan')
            ->get();
        return response()->json($ruangan);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = Ruangan::get();

        return view('ruangans.edit', [
            'item' => $edit[0]
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
        $data = $request->all();

        Ruangan::where('id_ruangan', '=', $id)
            ->update(['gedung' => $data['gedung'], 'ruangan' => $data['ruangan'], 'keterangan' => $data['keterangan'], 'updated_at' => Carbon::now()]);
            
        return redirect()->route('ruangans.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ruangan = Ruangan::where('id_ruangan', '=', $id)->get();

        Ruangan::where('id_ruangan', $ruangan[0]['id_ruangan'])
            ->update(['updated_at' => Carbon::now(), 'deleted_at' => Carbon::now()]);

        return redirect()->route('ruangans.index');
    }

    public function export() 
    {
        $ged = (request('gedung')==NULL) ? '' : request('gedung');
        $rua = (request('ruangan')==NULL) ? '' : request('ruangan');
        $kon = (request('kondisi')==NULL) ? '' : request('kondisi');
        $kat = (request('id_kategori')==NULL) ? '' : request('id_kategori');

        date_default_timezone_set('Asia/Jakarta');
        return Excel::download(new RuanganExport($ged, $rua, $kon, $kat), $kat." ".$ged." ".$rua." ".$kon." ".date('d-m-Y').'.xlsx');
    }
}
