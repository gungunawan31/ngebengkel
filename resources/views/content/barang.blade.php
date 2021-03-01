@extends('template.master')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Stock</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Stock</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <h3 align="center">Daftar Stok</h3>
            <div class="card shadow">
                <div class="card-header">
                    <button class="btn btn-success mb-2" data-toggle="modal" data-target="#Modal" onclick="modal('Modal')">Tambah Stok Barang</button>

                    <table class="table table-hover table-bordered table-striped" id="table">
                            <thead>
                                <tr>
                                    <th>ID Karyawan</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>No. Hp</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID Karyawan</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>No. Hp</th>
                                    <th>Email</th>
                                    <th>Status</th>
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
                    <form id="form" action="insertBarang" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group">
                          <label>Nama Barang</label>
                          <input type="text" class="form-control" id="nama" name="nama">
                          <small id="nama_error" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                          <label>Tanggal Barang Masuk</label>
                          <input type="date" class="form-control" id="date" name="date">
                          <small id="date_error" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                          <label>Deskripsi</label>
                          <input type="text" class="form-control" id="deskripsi" name="deskripsi">
                          <small id="deskripsi_error" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>harga barang</label>
                            <input type="text" class="form-control" id="harga" name="harga">
                            <small id="harga_error" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>stok barang</label>
                            <input type="text" class="form-control" id="stok" name="stok">
                            <small id="stok_error" class="form-text text-danger"></small>
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

@section('script')
    <script type="text/javascript">
       
        function updateToactive(data,status){
            $.ajax({
                url:"{{url('/UpdateStatusBarang')}}/"+data+"/"+status,
                success:function(response){
                  success(response.message);
                  tableReload();
                },
                error:function(response){
                    failed(response.message)
                }
            })
        }
        function deleteBarang(data){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                preConfirm: function(){
                    $.ajax({
                        url:"{{url('/deleteBarang')}}/"+data,
                        success:function(response){
                            success(response.message);
                            tableReload();
                        },
                        error:function(response){
                            failed(response.message)
                        }
                    })
                }
            });
        }
        function editBarang(id){
            $.ajax({
                url:"{{url('/getDataBarangById')}}/"+id,
                success:function(response){
                    var data = response.data;
                    showingData(data);

                },
                error:function(response){
                    console.log('tost')
                }
            })
        }

        function tableReload(){
            var tables = $('#table').DataTable();
			tables.ajax.reload();
        }
        function insert(){
            var data = $('#form').serialize();
            $.ajax({
                header:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'post',
                data : data,
                url : "{{url('/insertBarang')}}",
                success: function(response){
                    $('#Modal').modal('hide');
                    success(response.message);
                    tableReload();
                },
                error:function(response){
                    var data = response.responseJSON.error ;
                    validate(data);
                    console.log(data);
                }
            })
        }

        function validate(data){
            function validate(data){
            if(data.hasOwnProperty('nama')){
                $('#nama_error').text(data.nama)
            }else{
                $('#nama_error').text('');
            }
            if(data.hasOwnProperty('date')){
                $('#date_error').text(data.date)
            }else{
                $('#date_error').text('')

            }
            if(data.hasOwnProperty('deskripsi')){
                $('#deskripsi_error').text(data.deskripsi)
            }else{
                $('#deskripsi_error').text('')
            }
            if(data.hasOwnProperty('harga')){
                $('#harga_error').text(data.harga)
            }else{
                $('#harga_error').text('')
            }
            if(data.hasOwnProperty('stok')){
                $('#stok_error').text(data.stok)
            }else{
                $('#stok_error').text('')
            
            }
        }
        function showingData(data){
            $('#nama').val(data.nama_barang)
            $('#date').val(data.tanggal_barang)
            $('#deskripsi').val(data.deskripsi_barang)
            $('#harga').val(data.harga_barang)
            $('#stok').val(data.stok_barang)
            $('<input>').attr({
                type: 'hidden',
                id: 'id_barang',
                name: 'id_barang',
                value: data.id_barang
            }).appendTo('form');
        }
        function modal(data,id){
            $('small').text('');
            $('#form').trigger("reset");
            $("input[id='id_barang']").remove();
            $('#Modal').modal('show');
            $('h5').text(data+'Barang');
            if(data=='Tambah'){
                $('#submit').attr('onclick','insert()');
            }else{
                editBarang(id);
                $('#submit').attr('onclick','update('+"'"+id+"'"+')')
            }
        }
        function update(id)
        {
            var data = $('#form').serialize();
            $.ajax({
                header:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"post",
                url:"{{url('/UpdateBarang')}}",
                data:data,
                success:function(response){
                    $('#Modal').modal('hide');
                    success(response.message);
                    tableReload();
                },
                error:function(response){
                    var data = response.responseJSON.error ;
                    validate(data);
                }
                
            })
        }


    </script>
@endsection