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
<div class="row">
<div class="col-lg12">
<form id="form" action="{{ route('updateproduk',['id'=>$produk->id]) }}" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group">
                          <label>Nama Produk</label>
                          <input type="text" class="form-control" id="nama" name="nama" placeholder="nama produk" value="{{$produk->nama}}" >
                          <small id="nama_error" class="form-text text-danger"></small>
                        </div>
                      
                        <div class="form-group">
                          <label>Deskripsi Produk</label>
                          <input type="text" class="form-control" id="deskripsi" name="deskripsi"  placeholder="deskripsi produk" value="{{$produk->deskripsi}}">
                          <small id="deskripsi_error" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>stok Produk</label>
                            <input type="text" class="form-control" id="stok" name="stok"  placeholder="stok produk" value="{{$produk->stok}}">
                            <small id="stok_error" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>harga Produk</label>
                            <input type="text" class="form-control" id="harga" name="harga"  placeholder="harga produk" value="{{$produk->harga}}">
                            <small id="harga_error" class="form-text text-danger"></small>
                        </div>
 
                     
                        <button type="submit" class="btn btn-warning">Submit</button>
                    </form>
                    </div>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-warning">Save changes</button>
                </div> --}}
            </div>
            </div>
        </div>
        {{-- modal end --}}
    </section>
    <!-- /.content -->
</div>
@endsection




