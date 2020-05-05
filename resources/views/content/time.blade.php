@extends('template.master')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Time Service</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Time Service</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <h3 align="center">Daftar Time Service</h3>
            <div class="card shadow">
                <div class="card-header">
                    <button class="btn btn-success mb-2" onclick="modal('Tambah')">Tambah Time Service</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped" id="table">
                            <thead>
                                <tr>
                                    <th>ID Time Service</th>
                                    <th>Jam Service</th>
                                    <th>Status</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID Time Service</th>
                                    <th>Jam Service</th>
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
                          <label>Time Service</label>
                          <input type="text" class="form-control" id="time" name="time" placeholder="09:00-10:00">
                          <small id="time_error" class="form-text text-danger"></small>
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
                "ajax":"{{url('/getTime')}}",
                "columns":[
                    {"data":"id_time"},
                    {"data":"time"},
                    {
                      "data":"id_time",
                      "status_time_service":"status_time_service",
                      "render":function(data,type,row,status_time_service){
                          if(row.status_time_service=='0'){
                                return '<center><badge class="btn btn-sm btn-success mr-2" onclick="updateToactive('+"'"+data+"'"+','+"'Active'"+')" title="Click To Active Mechanic"><i class="fa fa-lock"></i></badge></center>';
                            }else if(row.status_time_service=='1'){
                                return '<center><badge class="btn btn-sm btn-primary mr-2" onclick="updateToactive('+"'"+data+"'"+','+"'Deactive'"+')" title="Click To Deactive Mechanic"><i class="fas fa-unlock"></i></badge></center';
                            }
                      }
                    },
                    {
                        "data":"id_time",
                        "render":function(data,type,row){
                                return '<center><badge class="btn btn-sm btn-info mr-2" onclick="modal('+"'Edit'"+','+"'"+data+"'"+')" title="Edit Mechanic"><i class="fas fa-edit"></i></badge><badge class="btn btn-sm btn-danger mr-2" onclick="deleteTime('+"'"+data+"'"+')" title="Delete Mechanic"><i class="fas fa-trash"></i></badge></center>';
                        }
                    },
                ],
                "responsive": true,
                dom: 'Bfrtip',
                buttons: [
                    'pageLength',
                    { extend: 'pdf', text: '<span class="btn btn-sm btn-info mr-2"><i class="fas fa-file-pdf fa-1x" aria-hidden="true"></i> PDF </span>'},
                    { extend: 'csv', text: '<span class="btn btn-sm btn-info mr-2"><spa class="fas fa-file-csv fa-1x"></i> CSV </span>'},
                    { extend: 'excel', text: '<span class="btn btn-sm btn-info mr-2"><i class="fas fa-file-excel" aria-hidden="true"></i> EXCEL </span>' },
                ]
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

        function validateResponse(response)
        {
            if(response.status=='failed'){
                if(response.hasOwnProperty('message')){
                    failed(response.message);
                }else{
                    failed('Please Try Again');
                }
            }else{
                success(response.message);
                tableReload();
            }
        }

        function updateToactive(data,status){
            $.ajax({
                url:"{{url('/UpdateStatusTime')}}/"+data+"/"+status,
                success:function(response){
                  validateResponse(response);
                },
                error:function(response){
                    failed(response.message);
                }
            })
        }

        function deleteTime(data){
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
                        url:"{{url('/deleteTime')}}/"+data,
                        success:function(response){
                            validateResponse(response);
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
                url:"{{url('/getDataTimeById')}}/"+id,
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
                url : "{{url('/insertTime')}}",
                success: function(response){
                    $('#Modal').modal('hide');
                    validateResponse(response);
                },
                error:function(response){
                    var data = response.responseJSON.error ;
                    validate(data);
                }
            })
        }


        function validate(data){
            if(data.hasOwnProperty('time')){
                $('#time_error').text(data.time)
            }else{
                $('#time_error').text('');
            }
        }

        function showingData(data){
            $('#time').val(data.time)
            $('<input>').attr({
                type: 'hidden',
                id: 'id_time',
                name: 'id_time',
                value: data.id_time
            }).appendTo('form');
        }

        function modal(data,id){
            $('small').text('');
            $('#form').trigger("reset");
            $("input[id='id_mecanic']").remove();
            $('#Modal').modal('show');
            $('h5').text(data+' Time Service');
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
                url:"{{url('/UpdateTime')}}",
                data:data,
                success:function(response){
                    $('#Modal').modal('hide');
                    validateResponse(response);
                },
                error:function(response){
                    var data = response.responseJSON.error ;
                    validate(data);
                }
                
            })
        }


    </script>
@endsection