@extends('layouts.layout')
@section('content')

<div>
    <div class="float-start">
        <h4 class="pb-3">Create Project</h4>
    </div>
    <div class="float-end">
        <a href="{{route('projects.index')}}" class="btn btn-info">
            All Project
        </a>
    </div>
    <div class="clearfix"></div>
</div>

<div class="card">
    <div class="card-header">
        Create Project
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

        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Project Name</label>
                <input type="text" class="form-control" name="name" id="projectName" value="{{ old('name') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-danger">Cancel</a>

        </form>
    </div>
</div>

@endsection