<div class="mx-8">
    <form method="post" action="{{$route}}">
        @csrf
        <div class="card w-full ">
            <div class="card-body">
                <div class="grid grid-cols-12 px-4">
                    @if (isset($project->id))
                    <input type="hidden" name="project_id" value="{{$project->id}}">
                    @endif
                    <div class="col-span-12 text-left">Name</div>
                    <div class="col-span-12 text-left"><input type="text" name="name" value="{{$project->name ?? ''}}">
                    </div>
                    <div class="col-span-12 text-left">Description</div>
                    <div class="col-span-12"><textarea name="description"
                                                       class="w-full">{{$project->description ?? ''}}</textarea></div>
                </div>


            </div>
            <div class="card-footer w-full flex justify-end">
                <button class="btn btn-primary col-span-1 text-center">Add Project</button>
            </div>
        </div>
    </form>

</div>
