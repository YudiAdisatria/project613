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
use Illuminate\Support\Facades\Gate;

class KategoriController extends Controller
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
            $kategori = Kategori::where('id_kategori', 'like', '%'. request('search') . '%')
                ->orWhere('nama_kategori', 'like', '%'. request('search') . '%')
                ->paginate(15);
            
            return view('kategoris.index', [
                'kategori' => $kategori
            ]);
        }

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
            //Compress Image Code Here
            //KategoriController::compress($data['foto_kategori']);
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
            
            //Compress Image Code Here
            //KategoriController::compress($data['foto_kategori']);
            
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

    public function compress($path){
        $filepath = public_path(Storage::url($path));
        $mime = mime_content_type($filepath);
        $output = new \CURLFile($filepath, $mime, $filepath);
        $photo = ["files" => $output];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://api.resmush.it/?qlty=70');
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $photo);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            $result = curl_error($ch);
        }
        curl_close ($ch);
        
        $arr_result = json_decode($result);
        
        // store the optimized version of the image
        $ch = curl_init($arr_result->dest);
        $fp = fopen($filepath, 'wb');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
    }
}
