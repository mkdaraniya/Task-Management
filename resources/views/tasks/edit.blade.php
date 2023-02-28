@extends('layouts.layout')
@section('content')

<div>
    <div class="float-start">
        <h4 class="pb-3">Edit Tasks</h4>
    </div>
    <div class="float-end">
        <a href="{{route('index')}}" class="btn btn-info">
            All Task
        </a>
    </div>
    <div class="clearfix"></div>
</div>

            <div class="card">
                <div class="card-header">
                        Edit Task
                </div>
                <div class="card-body">
                @if(count($errors)>0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('tasks.update',['task' => $task->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Task Name</label>
                            <input type="text" class="form-control" name="name" id="taskName" value="{{ $task->name }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Task Priority</label>
                            <input type="number" class="form-control" name="priority" id="taskPriority" value="{{ $task->priority }}" >
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Select Project</label>
                            <select class="form-control" name="project_id">
                                <option value="">-</option>
                                @foreach( $projects as $project )
                                    <option value="{{ $project->id }}" @if ($project->id == $task->project_id) {{ 'selected' }} @endif>{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('tasks.index') }}" class="btn btn-warning">Cancel</a>

                    </form>
                </div>
            </div>

@endsection