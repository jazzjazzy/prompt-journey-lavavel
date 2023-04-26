@extends('layouts.modal')

@section('content')
<main>
    @include('projects.partials.addEdit', ['route' => route('project.save'), 'project' => $project])
</main>
@endsection
