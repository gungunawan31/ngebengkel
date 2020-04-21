@extends('template.master')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Service Order</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Service Order</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <h3 align="center">Daftar Service</h3>
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped table-sm" id="table">
                            <thead>
                                <tr>
                                    <th>ID Servic</th>
                                    <th>Nama Pemesan</th>
                                    <th>Tanggal Service</th>
                                    <th>Jam Service</th>
                                    <th>Keluhan</th>
                                    <th>Nama Mecanic</th>
                                    <th>Status Service</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID Servic</th>
                                    <th>Nama Pemesan</th>
                                    <th>Tanggal Service</th>
                                    <th>Jam Service</th>
                                    <th>Keluhan</th>
                                    <th>Nama Mecanic</th>
                                    <th>Status Service</th>
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
                          <select class="form-control" id="time" name="time">
                              <option value="">Select Time Service</option>
                          </select>
                          <small id="time_error" class="form-text text-danger"></small>
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <span id="submit" class="btn btn-primary" onclick="insert()">Submit</span>
                    </form>
                </div>
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
                "ajax":"{{url('/getService')}}",
                "columns":[
                    {"data":"id_service"},
                    {"data":"nama_lenkap"},
                    {"data":"date_book"},
                    {
                        "data":"time",
                        "id_service":"id_service",
                        "render":function(data,type,row,id_service){
                            if(data==null){
                                return '<center><badge class="btn btn-success btn-sm" onclick="modal('+"'"+row.id_service+"'"+')">Select Time<badge></center>'
                            }else{
                                return data
                            }
                        }
                    },
                    {"data":"complaint"},
                    {"data":"nama_mecanic"},
                    {
                        "data":"flag_status",
                        "render":function(data,type,row,){
                            if(data==null){
                                    return '<center>Waiting Time Service</center'
                                }else if(data=='1'){
                                    return '<center>Waiting The Customer</center'
                                }else if(data=='2'){
                                    return '<center>the car is being serviced</center'
                                }else{
                                    return 'serviced done'
                                }
                        }
                    },
                    {
                        "data":"id_service",
                        "flag_status":"flag_status",
                        "render":function(data,type,row,flag_status){
                            if(row.flag_status==null){
                                return '<center><badge class="btn btn-sm btn-danger mr-2" onclick="deleteService('+"'"+data+"'"+')" title="Delete Service"><i class="fas fa-trash"></i></badge></center>'
                            }else if(row.flag_status=='1'){
                                return '<center><badge class="btn btn-sm btn-info mb-2" onclick="CarStatus('+"'"+data+"','arrived'"+')" title="Car Arrived"><i class="fas fa-warehouse"></i></badge><badge class="btn btn-sm btn-danger ml-2 mb-2" onclick="deleteService('+"'"+data+"'"+')" title="Delete Service"><i class="fas fa-trash"></i></badge></center>'
                            }else if(row.flag_status=='2'){
                                return '<center><badge class="btn btn-sm btn-success mb-2" onclick="CarStatus('+"'"+data+"','done'"+')" title="Service Done"><i class="fas fa-check-double"></i></badge><badge class="btn btn-sm btn-danger ml-2 mb-2" onclick="deleteService('+"'"+data+"'"+')" title="Delete Service"><i class="fas fa-trash"></i></badge></center>'
                            }else{
                                return 'no option available'
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

        function deleteService(data){
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
                        url:"{{url('/deleteService')}}/"+data,
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

        function CarStatus(id,status){
            var keterangan = '';
            var nstatus = '';
            if(status=='arrived'){
                keterangan = 'The car has arrived';
                nstatus = '2';
            }else{
                keterangan = 'The car is finished in service'
                nstatus = '3';
            }
            Swal.fire({
                title: 'Are you sure?',
                text: keterangan,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes !',
                preConfirm: function(){
                    $.ajax({
                        url:"{{url('/updateCar')}}/"+id+"/"+nstatus,
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
                url : "{{url('/insertTimeService')}}",
                success: function(response){
                    $('#Modal').modal('hide');
                    validateResponse(response);
                },
                error:function(response){
                    var data = response.responseJSON.error ;
                    validate(data);
                    console.log(data);
                }
            })
        }

        function getTime()
        {
            $.ajax({
                url:"{{url('/getTime')}}",
                success:function(response){
                    $.each(response.data,function(key,val){
                        $('#time').append('<option value="'+val.id_time+'">'+val.time+'</option>');
                    })
                },
                failed:function(response){
                    failed()
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

        function modal(id){
            $('small').text('');
            $('#form').trigger("reset");
            $("input[id='id_mecanic']").remove();
            $('#Modal').modal('show');
            $('h5').text('Time Service');
            $('#time').empty();
            $('<input>').attr({
                type: 'hidden',
                id: 'id_service',
                name: 'id_service',
                value: id
            }).appendTo('form');
            getTime();
            
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