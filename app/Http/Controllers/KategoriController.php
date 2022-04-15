<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\URL;
use App\Http\Requests\KategoriRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = Kategori::paginate(15);
        return view('kategoris.index', [
            'kategori' => $kategori
        ]);
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kategoris.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KategoriRequest $request)
    {
        $data = $request->all();

        if($request->file('foto_kategori')){
            $data['foto_kategori'] = $request->file('foto_kategori')->store('assets/kategori', 'public');
        }
        Kategori::create($data);

        return redirect()->route('kategoris.index');
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
    public function edit($kategori)
    {
        $edit = Kategori::where('id_kategori', '=', $kategori)->get();

        return view('kategoris.edit', [
            'item' => $edit
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();
        $kategori = Kategori::where('id_kategori', '=', $data['id_kategori'])->get();
        
        Validator::make($data, [
            'id_kategori' => [
                'required',
                Rule::unique('kategori')->ignore($kategori[0]->id_kategori, 'id_kategori'),
            ],
        ]);

        if($request->file('foto_kategori')){
            $data['foto_kategori'] = $request->file('foto_kategori')->store('assets/kategori', 'public');
            
            //remove URL/storage from getAttribute model foto
            $temp = URL::to('/')."/storage/";
            $temp1 = Str::remove($temp, $kategori[0]['foto_kategori']);
            
            //delete photo
            Storage::disk('public')->delete($temp1);

            Kategori::where('id_kategori', $data['id_kategori'])
                ->update(['nama_kategori' => $data['nama_kategori'], 'foto_kategori' => $data['foto_kategori'], 'updated_at' => Carbon::now()]);
        }else{
            Kategori::where('id_kategori', $data['id_kategori'])
                ->update(['nama_kategori' => $data['nama_kategori'], 'updated_at' => Carbon::now()]);
        }

        return redirect()->route('kategoris.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($request)
    {
        $kategori = Kategori::where('id_kategori', '=', $request)->get();

        /* Delete foto */
        $temp = URL::to('/')."/storage/";
        $temp1 = Str::remove($temp, $kategori[0]['foto_kategori']);
        Storage::disk('public')->delete($temp1);

        Kategori::where('id_kategori', $kategori[0]['id_kategori'])
                ->update(['updated_at' => Carbon::now(), 'deleted_at' => Carbon::now()]);

        return redirect()->route('kategoris.index');
    }
}
