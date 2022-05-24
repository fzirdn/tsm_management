<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\NewTask;
use App\Models\User;
use Carbon\carbon;
use Log;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class AdminTasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::pluck( 'name', 'id' );
        $users = User::where('type', '0')
                       ->pluck('name', 'id');
        
        //Display only last week and this week data only
        $previous_week = strtotime("-2 week +1 week ");
        $start_week = strtotime("last sunday midnight", $previous_week);
        $start_week = date("Y-m-d", $start_week);
        

        $userId = Auth::user()->id;
        $new_task = NewTask::with('projects', 'user')
                           ->where(['user_id' => $userId])
                           ->whereBetween('created_at', [$start_week, Carbon::now()->endOfWeek()])
                           ->orderBy('created_at', 'ASC')
                           ->paginate(10);
        
        //carbon for get current week
        $now = Carbon::now()->weekOfYear;


        return view('admin.weeklyTasks.index', compact('projects', 'users', 'new_task', 'now'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::pluck( 'name', 'id' );
        $now = Carbon::now();
        $week_number = $now->weekOfYear;

        //dd($week_number);

        return view('admin.weeklyTasks.taskForm', compact('projects', 'week_number' ));
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
                    'week_number' => $request-> week_number[$i],
                    ]);   
        }

        return redirect()->route('Admintasks.index')
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

        return redirect()->route('Admintasks.index')
            ->with('success','Task Updated successfully.');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $new_tasks =  NewTask::find($id);
        $new_tasks->delete();

        return redirect()->route('Admintasks.index')
       ->with('success','Task deleted successfully');
    }

    public function search( Request $request)
    {
        //Display only last week and this week data only
        $previous_week = strtotime("-2 week +1 week ");
        $start_week = strtotime("last sunday midnight", $previous_week);
        $start_week = date("Y-m-d", $start_week);


        $new_task = NewTask::with('projects', 'user')
            ->where('project_id', 'like', '%'. request('search') .'%' )
            ->whereBetween('created_at', [$start_week, Carbon::now()->endOfWeek()])
            ->paginate(6);

        $projects = Project::pluck( 'name', 'id' );
        $users = User::where('type', '0')
                       ->pluck('name', 'id');

        
        
        return view('admin.weeklyTasks.index', compact('new_task', 'projects', 'users'));
    }

    public function searchWeek( Request $request)
    {
        $search = Request::get('searchWeek');
        
    }
    
}
