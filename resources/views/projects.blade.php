@extends('layouts.app')

@section('content')


<div class="m-auto justify-center items-center">
    <h1 class="w-1/2 text-2xl mx-auto mt-10">Projects</h1>
    <table class="w-1/2 mx-auto">
        <thead>
            <tr>
                <th class="text-left">Name</th>
                <th class="text-left">Description</th>
                <th class="text-left">Delete</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($projects as $project)
            <tr>
                <td >{{ $project->name }}</td>
                <td>{{ $project->description }}</td>
                <td><i class="fas fa-trash"></i>
                    <a href="{{route('dashboard.project', [$project->id])}}" <i class="fas fa-edit"></i></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
