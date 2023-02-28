@extends('layouts.layout')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">Projects</div>
                        
                    </div>
                </div>

                <div class="card-body">
                    @if( $projects->count() > 0 )
                        <ul class="list-group Projects" id="sortable">
                            @foreach( $projects as $project )
                                <li class="list-group-item" >
                                    <div class="row">
                                        <div class="col">{{ $project->name }}</div>
                                        <div class="col-auto"><a class="btn btn-info text-white" href="{{ route('projects.edit', $project->id) }}">Edit</a></div>
                                        <div class="col-auto">
                                            <form action="{{ route('projects.destroy', $project->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-success">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>There is no projects yet, <a href="{{ route('projects.create') }}">Create the first one.</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
