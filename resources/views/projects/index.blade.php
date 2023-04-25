@extends('layouts.app')

@section('content')
<main class="w-1/2 m-auto pt-12 pb-6">
    <h1 class="text-4xl font-bold">Current Projects</h1>
    <div class="m-auto flex justify-center items-center">

        <div class="card w-full">
            <div>
                <div class="grid grid-cols-12 px-4">
                    <div class="col-span-4">
                        <div class="grid grid-cols-11">
                            <div class="col-span-1 text-left">#</div>
                            <div class="col-span-10 text-left">Name</div>
                        </div>
                    </div>
                    <div class="col-span-7 text-left">Description</div>
                    <div class="col-span-1 text-left">Action</div>
                </div>
                <for
                    @foreach ($projects as $project)
                <div class="grid grid-cols-12 px-4 m-auto py-2 odd:bg-slate-100 even:bg-white">
                    <div class="col-span-11">
                        <a href="{{route('dashboard.project', [$project->id])}}">
                            <div class="grid grid-cols-11">
                                <div class="col-span-4">
                                    <div class="grid grid-cols-11">
                                        <div class="col-span-1 text-gray-400 text-sm">{{ $loop->index + 1 }}.</div>
                                        <div class="col-span-10">{{ $project->name }}</div>
                                    </div>
                                </div>
                                <div class="col-span-7">{{ $project->description }}</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-span-1">
                        <button class="open-modal px-1" data-url="{{route('project.edit', $project->id)}}"
                                data-modal-size="sm">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="delete-project  px-1" href="#"
                                data-project-url="{{route('project.delete', $project->id)}}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                @endforeach
                @if ($addButton === true)
                <button title="Add New Project"
                        class="open-modal add-project bg-blue-900 rounded-full h-12 w-12 flex items-center justify-center absolute -top-16 -right-0"
                        data-url="{{route('project.add')}}" data-modal-size="sm">
                    <i class="fa fa-plus text-4xl text-white"></i>
                </button>
                @else
                <div title="Excesses Project limit for this account"
                     class="bg-gray-300 rounded-full h-12 w-12 flex items-center justify-center absolute -top-16 -right-0">
                    <i class="fa fa-plus text-4xl text-white"></i>
                </div>
                @endif

            </div>
        </div>
    </div>

</main>
@endsection
