@extends('layouts.template')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status')}}
                </div>
            @endif

            <!-- Header-->
            <br> 
            <div class="mb-3 text-center">
                <div class="col-lg-12 margin-tb">
                    <h2>To Do List</h2>
                </div>
            </div>

            <!--First Box For Create New Task -->
            <div class="card card-new-task">
                <div class="card-header">Update To Do List</div>

                <div class="card-body">
                    <form action="{{ url('/todos/update/'.$new_todo->id)}}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="main-form"></div>
                        <div class="form-group">
                            <label>Project:</label>
                            <label><select required name="project_id" class="form-control">
                                <option value="">--Choose Project--</option>
                                @foreach ($projects as $id => $name)
                                <option 
                                    value="{{$id}}" {{ (isset($new_todo['project_id']) && $new_todo['project_id'] == $id) ? ' selected' : '' }}>{{$name}}</option>
                                @endforeach
                            </select></label>
                            <label for=""></label>
                            <label for="todos">Task:</label>
                            <label><input type="text" name="todo"  value="{{$new_todo->todo }}" class="form-control" required placeholder="Task" maxlength="255"></label>                         
                            <label for="status">
                                <select required name="status_id" class="form-control">
                                    <option value="">--Choose Status--</option>
                                    @foreach ($statuses as $id => $name)
                                    <option 
                                        value="{{$id}}" {{ (isset($new_todo['status_id']) && $new_todo['status_id'] == $id) ? ' selected' : '' }}>{{$name}}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                        <div class="text-right">
                            <a class="btn btn-primary" href="{{ route('todos.index') }}"> Back</a>
                        </div>
                        </div>

        
                        <button type="submit" name="save_data" class="btn btn-primary float-right">Update</button>
                        </div>
                    </form>
                </div>
                <!-- End For Create New To do List-->    
        </div>
    </div>       
</div>
@endsection


{{--Line graph--}}
<script type="text/javascript">
  
    var line_stacked_element = document.getElementById('line_stacked');
    if(line_stacked_element) {
      var line_stacked = echart.init(line_stacked_element);
      line_stacked.setOption({
        animationDuration: 750,
        grid: {
          left: 0,
          right: 20,
          top: 35,
          bottom: 0,
          containLabel: true
        },
        legend: {
          data: ['Office', 'GnD', 'Genting Kiosk', 'CHUBB'],
          itemHeight: 8,
          itemGap: 20
        },
  
        //tooltip
        tooltip: {
          trigger: 'axis',
          backgroundColor: 'rgba(0,0,0,0.75)',
          padding: [10, 15],
          textStyle: {
            fontSize: 13,
            fontFamily: 'Roboto, sans-serif'
          }
        },
  
        //X-axis which is the horizontal line
        xAxis: [{
          type: 'Days',
          boundaryGap: false,
          data: [
            'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'
          ],
          axisLabel: {
            color: '#333'
          },
          axisLine: {
            lineStyle: {
              color: '#999'
            }
          },
          splitLine:{
            lineStyle: {
              color: ['#eee']
            }
          }
        }],
  
        //Y-axis which is vertical line
        yAxis: [{
          type:'value',
          axisLabel: {
            color: '#333'
          },
          axisLine: {
            lineStyle: {
              color: '#999'
            }
          },
          splitLine:{
            lineStyle: {
              color: ['#eee']
            }
          },
          splitArea: {
            show:true,
            areaStyle: {
              color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.01)']
            }
          },
        }],
  
        //Add series
  
      })
    }
  </script>