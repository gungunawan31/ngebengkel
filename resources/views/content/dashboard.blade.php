@extends('template.master')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <h3 align="center">Welcome To Ngebengkel Admin</h3>
            <h5 align="center">Selamat Bekerja</h5>
        <h5><i>Grafik Pendaftar Baru</i></h5>
        <canvas id="myChart" width="" height="100"></canvas>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection

@section('script')
    <script>
      function label()
      {
        var response;
        $.ajax({
          url:"{{url('getLabel')}}",
          async: false,
          success:function(data){
           response = data.data
          },
        });
        return response;
        
      }

      var data = label();
      var arrayLabel = makeArrayLabel(data.label);
      var arrayData = makeArrayData(data.value);
      var ctx = document.getElementById('myChart');
      var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
              labels: arrayLabel,
              datasets: [{
                  label: '# of Votes',
                  data: arrayData,
                  backgroundColor: [
                      'rgba(255, 99, 132, 0.2)',
                      'rgba(54, 162, 235, 0.2)',
                      'rgba(255, 206, 86, 0.2)',
                      'rgba(75, 192, 192, 0.2)',
                      'rgba(153, 102, 255, 0.2)',
                      'rgba(255, 159, 64, 0.2)'
                  ],
                  borderColor: [
                      'rgba(255, 99, 132, 1)',
                      'rgba(54, 162, 235, 1)',
                      'rgba(255, 206, 86, 1)',
                      'rgba(75, 192, 192, 1)',
                      'rgba(153, 102, 255, 1)',
                      'rgba(255, 159, 64, 1)'
                  ],
                  borderWidth: 1
              }]
          },
          options: {
              scales: {
                  yAxes: [{
                      ticks: {
                          beginAtZero: true
                      }
                  }]
              },legend: {
                display: false
              }
          }
      });

      function makeArrayLabel(data)
      {
        var array = [];
        $.each(data,function(key,value){
          var bulan = value.bulan;
          if (bulan == 1){
            array.push("Januari");
          }else if(bulan ==2 ){
            array.push("Febuari");
          }else if(bulan ==3 ){
            array.push("Maret");
          }else if(bulan ==4 ){
            array.push("April");
          }else if(bulan ==5 ){
            array.push("Mei");
          }else if(bulan ==6 ){
            array.push("Juni");
          }else if(bulan ==7 ){
            array.push("Juli");
          }else if(bulan ==8 ){
            array.push("Agustus");
          }else if(bulan ==9 ){
            array.push("September");
          }else if(bulan ==10 ){
            array.push("Oktober");
          }else if(bulan ==11 ){
            array.push("November");
          }else if(bulan ==2 ){
            array.push("Desember");
          }
        })
        return array;
      }
      function makeArrayData(data)
      {
        var array = [];
        $.each(data,function(key,value){
          array.push(value.pendaftar);
        })
        return array;
      }
      
    </script>
@endsection