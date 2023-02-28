<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks    = Task::orderBy('priority', 'asc')->get();
        $projects = Project::hasTasks()->get(); 
        return view('tasks.index', compact('tasks', 'projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all();
        return view('tasks.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        $maxPrioroty = Task::max('priority') ?: 0;

        $newTask             = new Task();
        $newTask->name       = $request->name;
        $newTask->project_id = $request->project_id;
        $newTask->priority   = ++$maxPrioroty;

        $newTask->save();

        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task     = Task::findOrFail($id);
        $projects = Project::all();
        return view('tasks.edit', compact('task', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::findOrFail($id);

        $request->validate([
            'name'       => 'required',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        $task->name       = $request->name;
        $task->project_id = $request->project_id;

        $task->save();

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);

        Task::where('priority', '>', $task->priority)
            ->update(['priority' => \DB::raw('priority - 1')]);

        $task->delete();

        return redirect()->route('tasks.index');
    }
    
    /**
     * update Priority for task list.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePriority(Request $request)
    {

        $task = Task::findOrFail($request->input('task_id'));
        $prev = Task::find( $request->input('prev_id') );

        if( !$request->input('prev_id') ){            
            $destination = 1;
        }else if( !$request->input('next_id') ){
            $destination = Task::count();
        }else{
            $destination = $task->priority < $prev->priority ? $prev->priority : $prev->priority + 1;
        }
        
        Task::where('priority', '>', $task->priority)
            ->where('priority', '<=', $destination)
            ->update(['priority' => \DB::raw('priority - 1')]);

        Task::where('priority', '<', $task->priority)
            ->where('priority', '>=', $destination)
            ->update(['priority' => \DB::raw('priority + 1')]);

        $task->priority = $destination;
        $task->save();

        return response()->json(true);
    }
}
