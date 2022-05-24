<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\employee;
use App\Models\Project;
use App\Models\NewTask;
use Carbon\carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Log;


class NewTaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Log::channel('errorlogcustom')->error("'Sorry! Something is wrong with this Task table!");
        //Log::channel('custom')->info("This is testing for Task index");


        //view data from today and yesterday data
        //$startData = Carbon::yesterday();
        //$endData = Carbon::now();

        //to get last week data 
        $previous_week = strtotime("-2 week +1 week ");
        $start_week = strtotime("last sunday midnight", $previous_week);
        $start_week = date("Y-m-d", $start_week);
        
        //current week data


        

        $userId = Auth::user()->id;
        $new_task =  NewTask::with('projects')
                            ->where(['user_id' => $userId])
                            ->where('progress', '!=', '100')
                            ->whereBetween('created_at', [$start_week, Carbon::now()->endOfWeek()])
                            ->paginate(6);

        /*$new_task =  NewTask::with('projects', 'employees')
                     ->whereBetween('created_at', [$startData, $endData])
                     ->paginate(6);*/

        //$new_task = NewTask::latest();

        

        $projects = Project::pluck( 'name', 'id' );

        return view('tasks.index',compact('new_task', 'projects'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::pluck( 'name', 'id' );
        return view('tasks.taskForm', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $task = $request -> task;
        $user_id = $request->user()->id;
        

        for($i=0; $i < count($task); $i++) {

            NewTask::firstorCreate([
                    'user_id' => $user_id,
                    'project_id' => $request-> project_id,
                    'task' => $request-> task[$i],
                    'effort_hours' => $request->effort_hours[$i],
                    'progress' => $request-> progress[$i],
                    ]);   
        }

        return redirect()->route('tasks.index')
                        ->with('success','Task created successfully.');

        
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $projects = Project::pluck( 'name', 'id' );
        $progress = NewTask::pluck('progress');

        //update
        /*$new_tasks = NewTask::find($id);
        return view('tasks.edit', compact('projects', 'new_tasks', 'progress'));*/

        //update
        $new_task = NewTask::find($id);
        return response()->json($new_task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $projects = Project::pluck( 'name', 'id' );
        $progress = NewTask::pluck('progress');

        Log::debug($id);
        Log::debug($request->id);
        $new_task = NewTask::find($request->id);
        $new_task->id = $request->input('id');
        $new_task->project_id = $request->input('project_id');
        $new_task->task = $request->input('task');
        $new_task->effort_hours = $request->input('effort_hours');
        $new_task->progress = $request->input('progress');
        $new_task->update();

        return redirect()->route('tasks.index')
            ->with('success','Task Updated successfully.');

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\NewTask $new_task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $new_tasks =  NewTask::find($id);
        $new_tasks->delete();

        return redirect()->route('tasks.index')
       ->with('success','Task deleted successfully');
    }

    public function showcompleted( Request $request )
    {

        $userId = Auth::user()->id;
        $progress = $request->progress;

        $previous_week = strtotime("-2 week +1 week ");
        $start_week = strtotime("last sunday midnight", $previous_week);
        $start_week = date("Y-m-d", $start_week);



        $new_task =  NewTask::with('projects')
                            ->where(['user_id' => $userId])
                            ->where('progress', '100')
                            ->whereBetween('created_at', [$start_week, Carbon::now()->endOfWeek()])
                            ->paginate(6);


        $projects = Project::pluck( 'name', 'id' );

        return view('tasks.index', compact( 'new_task','projects'));
    }

    public function showDeleted( Request $request)
    {
        $userId = Auth::user()->id;
        
        //show only last week data 
        $previous_week = strtotime("-2 week +1 week ");
        $start_week = strtotime("last sunday midnight", $previous_week);
        $start_week = date("Y-m-d", $start_week);

        $new_task = NewTask::onlyTrashed()
                           ->with('projects')
                           ->where(['user_id' => $userId])
                           ->whereBetween('created_at', [$start_week, Carbon::now()->endOfWeek()])//condition which it will show only this week and last week data 
                           ->paginate(10);
        
        $projects = Project::pluck( 'name', 'id' );
    

        return view('tasks.index', compact('new_task', 'projects'));
    }

    public function search( Request $request)
    {
        $userId = Auth::user()->id;
        $new_task = NewTask::with('projects')
            ->where(['user_id' => $userId])
            ->where('project_id', 'like', '%'. request('search') .'%' )
            ->paginate(6);

        $projects = Project::pluck( 'name', 'id' );
        
        return view('tasks.index', compact('new_task', 'projects'));
    }


}
