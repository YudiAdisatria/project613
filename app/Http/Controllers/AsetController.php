<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        
        if(request('search')){
            $aset = Aset::with(['kategori'])
                ->where('id_aset', 'like', '%'. request('search') . '%')
                ->orWhere('nama_aset', 'like', '%'. request('search') . '%')
                ->orWhere('gedung', 'like', '%'. request('search') . '%')
                ->orWhere('ruangan', 'like', '%'. request('search') . '%')
                ->paginate(15);
            
            return view('asets.index', [
                'aset' => $aset
            ]);
        }

        $aset = Aset::with(['kategori'])->paginate(7);

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
        $data['edited_by'] = auth()->user()['noHp'];

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
        $data = $request->all();
        $data['edited_by'] = auth()->user()['noHp'];
        
        $aset = Aset::where('id_aset', '=', $id)->get();

        if($request->file('foto_aset')){
            $data['foto_aset'] = $request->file('foto_aset')->store('assets/aset', 'public');
            
            //remove URL/storage from getAttribute model foto
            $temp = URL::to('/')."/storage/";
            $temp1 = Str::remove($temp, $aset[0]['foto_kategori']);
            
            //delete photo
            Storage::disk('public')->delete($temp1);

            Aset::where('id_aset', $id)
                ->update(['nama_aset' => $data['nama_aset'], 
                    'gedung' => $data['gedung'], 
                    'ruangan' => $data['ruangan'], 
                    'kondisi' => $data['kondisi'], 
                    'keterangan' => $data['keterangan'],
                    'edited_by' => $data['edited_by'],
                    'jenis_pindah' => "PINDAH",
                    'foto_aset' => $data['foto_aset'],  
                    'updated_at' => Carbon::now()
                ]);
        }else{
            Aset::where('id_aset', $id)
                ->update(['nama_aset' => $data['nama_aset'], 
                    'gedung' => $data['gedung'], 
                    'ruangan' => $data['ruangan'], 
                    'kondisi' => $data['kondisi'], 
                    'keterangan' => $data['keterangan'],
                    'edited_by' => $data['edited_by'], 
                    'jenis_pindah' => "PINDAH",
                    'updated_at' => Carbon::now()
                ]);
        }

        return redirect()->route('asets.index');
    }

    public function jual($id)
    {
        $edit = Aset::where('id_aset', '=', $id)->get();
        $kategori = Kategori::get();

        return view('asets.jual', [
            'item' => $edit[0],
            'kategori' => $kategori
        ]);
    }

    public function save(Request $request, $id)
    {
        $data = $request->all();
        $data['edited_by'] = auth()->user()['noHp'];

        $aset = Aset::where('id_aset', $id)
            ->update(['harga_jual' => $data['harga_jual'],
                'kondisi' => $data['kondisi'], 
                'keterangan' => $data['keterangan'], 
                'edited_by' => $data['edited_by'],
                'jenis_pindah' => "JUAL",
                'updated_at' => Carbon::now(), 
                'deleted_at' => Carbon::now()
            ]);

        return redirect()->route('asets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        /*
        $data = $request->all();

        $aset = Aset::where('id_aset', $id)
            ->update(['harga_jual' => $data['harga_jual'],
                'kondisi' => $data['kondisi'], 
                'keterangan' => $data['keterangan'], 
                'updated_at' => Carbon::now(), 
                'deleted_at' => Carbon::now()
            ]);

        return redirect()->route('asets.index'); 
        */
    }
}
