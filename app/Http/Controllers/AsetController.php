<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Aset;
use App\Models\Ruangan;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\AsetRequest;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

        $aset = Aset::with(['kategori'])->paginate(5);

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
        $ruangan = Ruangan::get('gedung')->groupBy('gedung');
        return view('asets.create', [
            'kategori' => $kategori,
            'ruangan' => $ruangan
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
            //$data['foto_aset'] = $request->file('foto_aset')->store('assets/aset', 'public');
            $data['foto_aset'] = $request->file('foto_aset')->store('assets/aset', 'public');
            
            //Compress Image Code Here
            AsetController::compress($data['foto_aset']);
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
        $edit = Aset::with(['kategori'])
            ->where('id_aset', '=', $id)->get();

        return view('asets.show', [
            'item' => $edit[0],
        ]);
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
        $ruangan = Ruangan::groupBy('gedung')->get('gedung');
        
        return view('asets.edit', [
            'item' => $edit[0],
            'kategori' => $kategori,
            'ruangan' => $ruangan
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

            //Compress Image Code Here
            AsetController::compress($data['foto_aset']);
            
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

    public function qr($id)
    {
        $aset = Aset::where('id_aset', $id)->get();
        $data = 'dashboard/asets/'.$id;
        $qr = QrCode::size(350)->generate($data);

        return view('asets.barcode', [
            'item' => $aset[0],
            'qr' => $qr
        ]);

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
