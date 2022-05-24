<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\NewTask;
use App\Models\NewTodo;
use Carbon\carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {



        $userId = Auth::user()->id;
        /** fetch new_task data to show in user dashboard */
        $new_task =  NewTask::with('projects')
                            ->where(['user_id' => $userId])
                            ->where('progress', '!=', '100')
                            ->orderBy('created_at', 'DESC')
                            ->paginate(5);

        $new_todo = NewTodo::with('projects', 'status')
                            ->where(['user_id' => $userId])
                            ->where('status_id', '!=' , 1)
                            ->orderBy('created_at', 'ASC')
                            ->paginate(5);
        
        
        /*$records = NewTask::select(DB::raw("SUM('effort_hours') as sum"))
                             ->whereYear('created_at', date('Y'))
                             ->groupBy(DB::raw("Month(created_at)"))
                             ->pluck('sum');
        
        $labels = $records->keys();
        $data = $records->values();*/

        

        


        return view('home', compact('new_task', 'new_todo'));
    }

    /* 

    public function userGraph( Request $request)
    {
        $records =  NewTask::select(DB::raw("SUM(effort_hours) as sum"))
                             ->whereYear('created_at', date('Y'))
                             ->groupBy(DB::raw("Month(created_at"))
                             ->pluck('count');

        
        return view('\home', compact('records'));

    
        /*$project_1 = NewTask::where('project_id', '1')
                            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]) 
                            ->sum('effort_hours')
                            ->get();
        $project_2 = NewTask::where('project_id', '2')
                            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                            ->sum('effort_hours')
                            ->get();
        $project_3 = NewTask::where('project_id', '3')
                            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                            ->sum('effort_hours') 
                            ->get();
        $project_4 = NewTask::where('project_id', '4')
                            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]) 
                            ->sum('effort_hours')
                            ->get();

        
        
        //return view('home', compact('project_1', 'project_2', 'project_3', 'project_4'));
    }*/
 
    public function adminHome()
    {
        return view('adminHome');
    }
}
