@extends('layouts.template')

{{-- For Line graph

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link href="{{asset('assets/css/components.min.css')}}" rel="stylesheet" type="text/css">	
	<script type="text/javascript" src="{{asset('assets/js/jquery.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>	
	<script type="text/javascript" src="{{asset('assets/js/echarts.min.js')}}"></script>

{{--end--}}

{{-- 
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> ---}}



@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


<!-- /.content-header -->   

    <div class="row justify-content-center">
        <div class="col-md-8">
            
          <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                  <div class="mb-3 text-center">
                    <div class="img-container-center">
                        <img style="width: 60% " src="{{ asset('admin/AdminLTE-3.1.0/dist/img/TSM_logo.png') }}" alt="TSM Logo">                    </div>
                  </div>
                  <div class="mb-3 text-center">
                      <h4>Welcome To Professional Services Team Task Management System</h4>
                  </div>
                </div>
            </div>

            {{--User Details--}}
          <div class="card">
            <div class="card-header"> User Details</div>
            
            <div class="card-body">
              <div class="mb-3 Text-left">
                 <h6> Name: {{ Auth::user()->name }}</h6>
                 <h6> Email: {{ Auth::user()->email}}</h6>
                 <h6> Username: {{ Auth::user()->username}}</h6>
              </div>
            </div>
          </div>
        </div>

        {{--Line Graph
        <div class="card">
          <div class="card-header">Line Graph</div>

          <div class="card-body">
            <div class="mb-3">
              <div class="chart-container">
                <canvas id="myChart" height="100px"></canvas>
              </div>
            </div>
          </div>
        </div>--}}

        {{-- Weekly Task --}}
        <div class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-6">
                <div class="card">
                  <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                      <div class="card-title">Weekly Tasks</div>
                      <a href="{{ route('tasks.index')}}">view page</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex">
                      <table class="table">
                        <tr>
                          <th>No</th>
                          <th>Project</th>
                          <th>Task</th>
                          <th>Progress</th>
                        </tr>
                        @foreach ($new_task as $key=>$item)
                        <tr>
                          <td>{{ $new_task->firstItem() + $key }}</td>
                          <td>{{ $item->projects->name }}</td>
                          <td>{{ $item->task }}</td>
                          <td>{{ $item->progress}}</td>
                        </tr>
                            
                        @endforeach
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              {{--Next Week Task--}}
              <div class="col-lg-6">
                <div class="card">
                  <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                      <div class="card-title">Next Week Tasks</div>
                      <a href="{{ route('todos.index')}}">view page</a>
                    </div>
                    <div class="card-body">
                      <div class="d-flex">
                        <table class="table">
                          <tr>
                            <th>No</th>
                            <th>Project</th>
                            <th>Task</th>
                            <th>status</th>
                          </tr>
                          @foreach ($new_todo as $key => $todos)
                          <tr>
                            <td>{{ $new_todo->firstItem() + $key}}</td>
                            <td>{{ $todos->projects->name }}</td>
                            <td>{{ $todos->todo }}</td>
                            <td>{{ $todos->status->name}}</td>
                          </tr>    
                          @endforeach
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              {{--End of Next week Task--}}
              
            </div>
          </div>
        </div>

    </div>
</div>

{{--
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript">
  
  var records =  {{ Js::from($data) }}

  const data = {
    
    datasets: [{
      label: 'Weekly effort hours',
      backgroundColor: 'rgb(255, 99, 132)',
      boderColor: 'rgb(255, 99, 132)',
      data: records,
    }]
  };

  const config = {
    type: 'line',
    data: data,
    option: {}
  };

  const myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
  
</script>--}}
@endsection

{{--
<script src="https://code.highcharts.com/highcharts.js"></script>

<script type="text/javascript">
    var records = <?php echo json_encode($records)?>;
    Highcharts.chart('container', {
        title: {
            text: 'New User 2021'
        },
        subtitle: {
            text: 'Bluebird youtube channel'
        },
        xAxis: {
            categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                'October', 'November', 'December'
            ]
        },
        yAxis: {
            title: {
                text: 'Number of New Users'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        plotOptions: {
            series: {
                allowPointSelect: true
            }
        },
        series: [{
            name: 'New Users',
            data: userData
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript">
  var labels  = {{ Js::from($labels) }}
  var records =  {{ Js::from($data) }}

  const data = {
    labels: labels,
    datasets: [{
      label: 'Weekly effort hours',
      backgroundColor: 'rgb(255, 99, 132)',
      boderColor: 'rgb(255, 99, 132)',
      data: records,
    }]
  };

  const config = {
    type: 'line',
    data: data,
    option: {}
  };

  const myChart = new Chart(
    document.getElementById('myChart'),
    config
  );

</script>--}}