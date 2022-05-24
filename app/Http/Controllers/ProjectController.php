<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\employee;
use App\Models\Project;



class ProjectController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::channel('errorlogcustom')->error("'Sorry! Something is wrong with this Project table!");
        Log::channel('custom')->info("This is testing for Project index");


         $project = Project::all();

        return view('projects.index', compact('project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.projectForm');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        /*Project::create([
            'name' => $request -> name,
            'logo' => $request -> logo,
            'description' => $request -> description,
        ]);*/

        /*$project = new Project;
        $project->name = $request->input('name');
        $project->logo =  $request->input('logo');
        $project->description = $request->input('description');
        /*if($request->hasfile('logo'))
        {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.extension;
            $file->move('public/projects', $filename);
        }*/

        /*if($file = $request->file('media')) {
            $fileData = $this->uploads($file, 'projects/logo');
            $media = Project::create([
                'name' => $fileData['name'],
                'logo' => $fileData['logo'],
                'description' => $fileData['description'],
            ]);
        }
        return $media;*/

        $request->validate([
            'name'=> 'required',
        ]);

        if($request->hasFile('logo')){
            
        }


        return redirect()->route('projects.index')
                         ->with('success', 'Project created succesfully');
                         
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
