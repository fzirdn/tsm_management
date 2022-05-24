<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\NewTodo;
use App\Models\Status;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Carbon\carbon;

class NewTodoController extends Controller
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
        $userId = Auth::user()->id;

        //show only this week data 
        $previous_week = strtotime("-2 week +1 week ");
        $start_week = strtotime("last sunday midnight", $previous_week);
        $start_week = date("Y-m-d", $start_week);

        $new_todo = NewTodo::with('projects', 'status')
                            ->where(['user_id' => $userId])
                            ->where('status_id', '!=' , 1)
                            ->whereBetween('created_at', [$start_week, Carbon::now()->endOfWeek()])//condition which it will show only this week and next week data 
                            ->paginate(6);

        $projects = Project::pluck('name', 'id');
        $statuses = Status::pluck('name', 'id');

        
        return view('todos.index', compact('new_todo', 'projects', 'statuses'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::pluck( 'name', 'id' );
        $statuses = Status::pluck( 'name', 'id' );

        return view('todos.todo', compact('projects', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$user_id = $request->user()->id;

        Todo::create([
            'user_id' => $user_id,
            'project_id' => $request-> project_id,
            'todo' => $request-> todo,
        ]);*/

        $todo = $request -> todo;
        $user_id = $request->user()->id;
        

        for($i=0; $i < count($todo); $i++) {

            NewTodo::firstorCreate([
                    'user_id' => $user_id,
                    'project_id' => $request-> project_id[$i],
                    'status_id' => $request-> status_id[$i],
                    'todo' => $request-> todo[$i],
                    ]);   
        }

        return redirect()->route('todos.index')
            ->with('success','Task deleted successfully');
        
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
        $projects = Project::pluck('name', 'id');
        $statuses = Status::pluck('name', 'id');

        //update
        $new_todos = NewTodo::find($id);
        return response()->json($new_todos);
        //return view('todos.edit', compact('projects', 'statuses', 'new_todo'));
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

        
        $projects = Project::pluck('name', 'id');
        $statuses = Status::pluck('name', 'id');
        
        $new_todo = NewTodo::find($request->id);
        $new_todo->id = $request->input('id');
        $new_todo->project_id = $request->input('project_id');
        $new_todo->status_id = $request->input('status_id');
        $new_todo->todo = $request->input('todo');
        $new_todo->update();
        

        return redirect()->route('todos.index')
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
        $new_todo = NewTodo::find($id);
        $new_todo->delete();

        return redirect()->route('todos.index')
       ->with('success','Task deleted successfully');
    }

    public function deleteCheckedTodos(Request $request)
    {        
        $ids = $request->ids;
        NewTodo::whereIn('id', $ids)->delete();
        return response()->json(['success'=>"Tasks have been deleted!"]);

    }

    public function showcompleted( Request $request)
    {
        $userId = Auth::user()->id;

        $statuses = Status::pluck('name', 'id');
        $projects = Project::pluck('name', 'id');

        //show only this week data 
        $previous_week = strtotime("-2 week +1 week ");
        $start_week = strtotime("last sunday midnight", $previous_week);
        $start_week = date("Y-m-d", $start_week);
        
        
        $new_todo =  NewTodo::with('projects', 'status')
                            ->where(['user_id' => $userId])
                            ->where('status_id', '1')
                            ->whereBetween('created_at', [$start_week, Carbon::now()->endOfWeek()])
                            ->paginate(6);
        
        return view('todos.index', compact('new_todo', 'projects', 'statuses'));

    }

    public function showDeleted( Request $request)
    {
        $userId = Auth::user()->id;

        $statuses = Status::pluck('name', 'id');
        $projects = Project::pluck('name', 'id');

        //show only this week data 
        $previous_week = strtotime("-2 week +1 week ");
        $start_week = strtotime("last sunday midnight", $previous_week);
        $start_week = date("Y-m-d", $start_week);


        $new_todo = NewTodo::onlyTrashed()
                           ->with('projects', 'status')
                           ->where(['user_id' => $userId])
                           ->whereBetween('created_at', [$start_week, Carbon::now()->endOfWeek()])//condition which it will show only this week and next week data 
                           ->orderBy('created_at', 'DESC')
                           ->paginate(6);
        

        return view('todos.index', compact('new_todo', 'projects', 'statuses'));
    }
}
