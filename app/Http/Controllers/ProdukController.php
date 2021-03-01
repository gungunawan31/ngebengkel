<?php

namespace App\Http\Controllers;
use App\Produk;

use Illuminate\Http\Request;


class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       if($request->has('cari')){
           $produk = Produk::where('nama','LIKE','%'.$request->cari.'%')->paginate();

       }else{

           $produk = Produk::all();   
       }

      return view('Content.produk', compact('produk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request,[
            'nama' => 'min:'

        ]);
        //dd($request->all());
   //\App\Produk::create($request->all());
   $produk = new \App\Produk;
   $produk->nama = $request->nama;
   $produk->deskripsi = $request->deskripsi;
   $produk->stok = $request->stok;
   $produk->harga = $request->harga;
   if ($request->hasFile('avatar')) {
       $files = $request->file('avatar');
       $path = public_path('images');
       $files_name = 'images' . '/' . $files->getClientOriginalName();
       $files->move($path, $files_name);
       $produk->avatar = $files_name;
   }
   $produk->save();
   return redirect('/produk')->with('sukses', 'Data produk telah tersimpan');

}

    public function edit($id)
    {
     $produk = \App\Produk::find($id);
     return view('content/edit',['produk'=>$produk]);

    
    }
    public function update(Request $request,$id)
    {
        $produk = \App\Produk::find($id);
        $produk->update($request->all());
        return redirect('/produk')->with('sukses','data produk berhasil di update');
    }

    public function delete($id)
    {
        $produk = \App\Produk::find($id);
        $produk->delete($produk);
        return redirect('/produk')->with('sukses','data produk berhasil di hapus');
    }
    public function profile($id){
        $produk = \App\Produk::find($id);
        return view('content/profile',['profil' => $produk]);

    }
}