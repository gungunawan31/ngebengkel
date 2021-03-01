@extends('template.master')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Produk</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Produk</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
        @if(session('sukses'))
        <div class="alert alert-primary" role="alert">
        {{session('sukses')}}
</div>
@endif
            <h3 align="center">Daftar Produk</h3>
            <div class="card shadow">
                <div class="card-header">
                    <button class="btn btn-success mb-2" data-toggle="modal" data-target="#Modal" onclick="modal('Modal')">Tambah  Produk</button>
<form class="form-inline my-2 my-lg-0" method="GET" >
<input name="cari" class="form-control mr-sm-2" type="search" placeholder="search" aria-label="search">
<button class="btn btn-outline-primary my-2 my-sm2" type= "submit">search</button>
</form>
</div>
                    <table class="table table-hover table-bordered table-striped" id="table">
<thead>
    <tr>
    <th>Nama Produk</th>
<th>Deskripsi Produk</th>
<th>Stok Produk</th>
<th>Harga Produk</th>
<th>Gambar Produk</th>
<th>Option</th>
</tr>
</thead>
@foreach($produk as $produk)

<tr>
<td>{{$produk->nama}}</td>
<td>{{$produk->deskripsi}}</td>
<td>{{$produk->stok}}</td>
<td>{{$produk->harga}}</td>
<td><img src="{{ asset($produk->avatar) }}" /></td>
<td>
<a href="{{ url('produk') . '/' . $produk->id . '/edit' }}" class="btn btn-warning btn-sm">edit</a>
<a href="{{ url('produk') . '/' . $produk->id . '/delete' }}" class="btn btn-danger btn-sm" onClick="return confirm ('Yakin Nih mau di Hapus??')">delete</a></td>
</tr>
@endforeach
<tfoot>
<tr>
<th>Nama Produk</th>
<th>Deskripsi Produk</th>
<th>Stok Produk</th>
<th>Harga Produk</th>
<th>Gambar Produk</th>
<th>Option</th>
                                </tr>
                            </tfoot>
                        </table>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                   
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
        <!-- Modal Tambah -->
        <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form" action="insertProduk/create" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="form-group">
                          <label>Nama Produk</label>
                          <input type="text" class="form-control" id="nama" name="nama" placeholder="Tuliskan nama produk">
                          <small id="nama_error" class="form-text text-danger"></small>
                        </div>
                        
                      
                        <div class="form-group">
                          <label>Deskripsi Produk</label>
                          <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Tuliskan deskripsi produk">
                          <small id="deskripsi_error" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>stok Produk</label>
                            <input type="text" class="form-control" id="stok" name="stok" placeholder="Tuliskan stok produk">
                            <small id="stok_error" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>harga Produk</label>
                            <input type="text" class="form-control" id="harga" name="harga" placeholder="Tuliskan harga produk">
                            <small id="harga_error" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Gambar Produk</label>
                            <input type="file" class="form-control" id="avatar" name="avatar">
                            <small id="avatar_error" class="form-text text-danger"></small>
                        </div>

                       
                        
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> --}}
            </div>
            </div>
        </div>
        {{-- modal end --}}
    </section>
    <!-- /.content -->
</div>
@endsection




