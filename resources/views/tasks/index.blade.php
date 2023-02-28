@extends('layouts.layout')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">Tasks</div>
                        <div class="col-auto">
                            <select class="form-control" name="projects">
                                <option value="">- All Projects -</option>
                                @foreach( $projects as $project )
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if( $tasks->count() > 0 )
                        <ul class="list-group tasks" id="sortable">
                            @foreach( $tasks as $task )
                                <li class="list-group-item" data-task-id="{{ $task->id }}" data-project-id="{{ $task->project ? $task->project->id : '' }}">
                                    <div class="row">
                                        <div class="col">{{ $task->name }}</div>
                                        <div class="col-auto">{{ $task->project ? $task->project->name : '' }}</div>
                                        <div class="col-auto"><a class="btn btn-info text-white" href="{{ route('tasks.edit', $task->id) }}">Edit</a></div>
                                        <div class="col-auto">
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>There is no tasks yet, <a href="{{ route('tasks.create') }}">Create the first one.</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

