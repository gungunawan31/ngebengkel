@extends('template.master')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Mechanic</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Mechanic</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <h3 align="center">Daftar Mechanic</h3>
            <div class="card shadow">
                <div class="card-header">
                    <button class="btn btn-success mb-2" onclick="modal('Tambah')">Tambah Mechanic</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
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
                    <form id="form">
                        {!! csrf_field() !!}
                        <div class="form-group">
                          <label>Nama Mechanic</label>
                          <input type="text" class="form-control" id="nama" name="nama">
                          <small id="nama_error" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                          <label>Tanggal Lahir</label>
                          <input type="date" class="form-control" id="date" name="date">
                          <small id="date_error" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Tempat Lahir</label>
                            <input type="text" class="form-control" id="tmpt_lahir" name="tmpt_lahir">
                            <small id="tmpt_lahir_error" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control"></textarea>
                            <small id="alamat_error" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>No. Telephone</label>
                            <input type="text" class="form-control" id="no_tlpn" name="no_tlpn">
                            <small id="no_tlpn_error" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" id="email" name="email">
                            <small id="email_error" class="form-text text-danger"></small>
                        </div>
                        
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <span id="submit" class="btn btn-primary">Submit</span>
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
        $(document).ready( function(){
            $('#table').DataTable({
                "ajax":"{{url('/getMechanic')}}",
                "columns":[
                    {"data":"id_mecanic"},
                    {"data":"nama_mecanic"},
                    {"data":"alamat_mecanic"},
                    {"data":"no_tlpn"},
                    {"data":"email_mecanic"},
                    {
                      "data":"id_mecanic",
                      "status_job":"status_job",
                      "render":function(data,type,row,status_job){
                          if(row.status_job==null){
                                return '<center>Ready</center'
                            }else if(row.status_job=='1'){
                                return '<center>On Job</center'
                            }
                      }
                    },
                    {
                        "data":"id_mecanic",
                        "status_mecanic":"status_mecanic",
                        "render":function(data,type,row,status_mecanic){
                            if(row.status_mecanic=='0'){
                                return '<center><badge class="btn btn-sm btn-success mr-2" onclick="updateToactive('+"'"+data+"'"+','+"'Active'"+')" title="Click To Active Mechanic"><i class="fa fa-lock"></i></badge><badge class="btn btn-sm btn-info mr-2" onclick="modal('+"'Edit'"+','+"'"+data+"'"+')" title="Edit Mechanic"><i class="fas fa-edit"></i></badge><badge class="btn btn-sm btn-danger mr-2" onclick="deleteMechanic('+"'"+data+"'"+')" title="Delete Mechanic"><i class="fas fa-trash"></i></badge></center>'
                            }else if(row.status_mecanic=='1'){
                                return '<center><badge class="btn btn-sm btn-primary mr-2" onclick="updateToactive('+"'"+data+"'"+','+"'Deactive'"+')" title="Click To Deactive Mechanic"><i class="fas fa-unlock"></i></badge><badge class="btn btn-sm btn-info mr-2" onclick="modal('+"'Edit'"+','+"'"+data+"'"+')" title="Edit Mechanic"><i class="fas fa-edit"></i></badge><badge class="btn btn-sm btn-danger mr-2" onclick="deleteMechanic('+"'"+data+"'"+')" title="Delete Mechanic"><i class="fas fa-trash"></i></badge></center>'
                            }
                        }
                    },
                ],
                "responsive": true
            });

            
        });

        function success(message){
            Swal.fire(
                'Good job!',
                message,
                'success'
            );
        }

        function failed(message){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: message,
            })
        }

        function updateToactive(data,status){
            $.ajax({
                url:"{{url('/UpdateStatusMechanic')}}/"+data+"/"+status,
                success:function(response){
                  success(response.message);
                  tableReload();
                },
                error:function(response){
                    failed(response.message)
                }
            })
        }

        function deleteMechanic(data){
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
                        url:"{{url('/deleteMecanic')}}/"+data,
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

        function editMechanic(id){
            $.ajax({
                url:"{{url('/getDataMecanicById')}}/"+id,
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
                url : "{{url('/insertMechanic')}}",
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
            if(data.hasOwnProperty('tmpt_lahir')){
                $('#tmpt_lahir_error').text(data.tmpt_lahir)
            }else{
                $('#tmpt_lahir_error').text('')
            }
            if(data.hasOwnProperty('alamat')){
                $('#alamat_error').text(data.alamat)
            }else{
                $('#alamat_error').text('')
            }
            if(data.hasOwnProperty('no_tlpn')){
                $('#no_tlpn_error').text(data.no_tlpn)
            }else{
                $('#no_tlpn_error').text('')
            }
            if(data.hasOwnProperty('email')){
                $('#email_error').text(data.email)
            }else{
                $('#email_error').text('')
            }
        }

        function showingData(data){
            $('#nama').val(data.nama_mecanic)
            $('#date').val(data.tlglahir_mecanic)
            $('#tmpt_lahir').val(data.tempatlahir_mecanic)
            $('#alamat').val(data.alamat_mecanic)
            $('#no_tlpn').val(data.no_tlpn)
            $('#email').val(data.email_mecanic)
            $('<input>').attr({
                type: 'hidden',
                id: 'id_mecanic',
                name: 'id_mecanic',
                value: data.id_mecanic
            }).appendTo('form');
        }

        function modal(data,id){
            $('small').text('');
            $('#form').trigger("reset");
            $("input[id='id_mecanic']").remove();
            $('#Modal').modal('show');
            $('h5').text(data+' Mechanic');
            if(data=='Tambah'){
                $('#submit').attr('onclick','insert()');
            }else{
                editMechanic(id);
                $('#submit').attr('onclick','update('+"'"+id+"'"+')')
            }
        }

        function update(id)
        {
            var data = $('#form').serialize();
            $.ajax({
                header:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"post",
                url:"{{url('/UpdateMechanic')}}",
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