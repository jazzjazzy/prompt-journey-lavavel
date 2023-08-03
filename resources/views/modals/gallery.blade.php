@extends('layouts.modal')

@section('content')
<div>
    @if (isset($projectId) && $projectId !== null)
    <input type="hidden" value="{{$projectId}}" name="projectId" id="projectId">
    @endif
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="wrapper overflow-hidden">
                        <div class="grid grid-cols-12 flex h-screen">
                            <div class="col-span-2 overflow-y-auto flex-1 mb-5">
                                @if (isset($groups) && $groups !== null)
                                <div class="h-full p-2">
                                    <nav>
                                        <h4 class="mt-6 border-b-2 border-solid border-indigo-600">Images</h4>
                                        <ul>
                                            <li class="group-item w-full cursor-pointer bg-blue-500 text-white"
                                                data-group="all">
                                                <a class="w-full group-details" data-group="all">
                                                    All Images
                                                </a>
                                            </li>
                                            <li class="group-item w-full cursor-pointer" data-group="current">
                                                <a class="w-full group-details" data-group="current">
                                                    In Current Project
                                                </a>
                                            </li>
                                            <li class="group-item w-full cursor-pointer" data-group="no-group">
                                                <a class="w-full group-details" data-group="no-group">
                                                    Not in group
                                                </a>
                                            </li>
                                        </ul>
                                        <h4 class="mt-6 border-b-2 border-solid border-indigo-600">Image Groups</h4>
                                        <ul>
                                            @foreach ($groups as $group)
                                            <li class="group-item w-full cursor-pointer group-details"
                                                data-group="{{$group->id}}">
                                                <a class="w-full group-details" data-group="{{$group->id}}">
                                                    {{$group->name}}
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </nav>
                                </div>
                                @endif
                            </div>
                            <div class="col-span-10 overflow-y-auto flex-1 mb-5">
                                @if (isset($images) && $images !== null)
                                <hi id="image-group-title" class="m-4 text-4xl">All Images</hi>
                                <div id="gallery-images" class="flex flex-wrap">
                                    @foreach ($images as $image)

                                    <a href="#" class="image-populate" data-image-url="{{$image->link}}"
                                       id="image-{{$image->id}}" data-in-image-list="false">
                                        <div class="w-[290px] m-2 relative overflow-hidden">
                                            <i class="fa-sharp fa-solid fa-circle-check text-green-700 absolute top-3 right-3"
                                               hidden></i>
                                            <div class="absolute bottom-0 left-0">
                                                <div class="viewData  text-gray-500">
                                                    <div class="text-xs p-1 viewItem">
                                                        <div class="label">Host</div>
                                                        <div class="data">
                                                            {{ $image->imageUrl['scheme']
                                                            }}://{{$image->imageUrl['host'] }}
                                                        </div>
                                                    </div>
                                                    <div class="text-xs px-1 pb-3 viewItem">
                                                        <div class="label">Path</div>
                                                        <div class="data">
                                                            {{ $image->imagePath['dirname'] }}/
                                                        </div>
                                                    </div>
                                                    <div class="text-xs px-1 viewItem">
                                                        <div class="label">Name</div>
                                                        <div class="data">
                                                            {{
                                                            $image->imagePath['filename']}}.{{$image->imagePath['extension']}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="w-[300px] h-[300px]">
                                                <img src="{{$image->link}}" alt="image" class="w-full h-full" style="object-fit: cover">
                                            </div>
                                        </div>
                                    </a>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="module">
    $(document).ready(function () {

        setCheckmarkGalleryImages();

        $(document).on('click', '.modal .image-populate', function () {
            let url = $(this).data('image-url');
            let idname = $(this).attr('id');
            let $isAlreadyInProject = $(this).attr('data-in-image-list');

            if($isAlreadyInProject === "true") {
                removeFromImageList(idname);
            }else{
                addToImageList(url, idname);
            }
        });


        $('.group-details').on('click', function () {
            $("nav li").removeClass("bg-blue-500 text-white");

            let groupId = $(this).data('group');
            let projectId = $('#projectId').val();

            if(groupId === "current") {
                groupId = 'all';
                var current = true;
            }

            $.ajax({
                url: '/gallery/'+groupId,
                type: 'GET',
                success: function (data) {
                    $('#gallery-images').html('');
                    data.images.forEach(function (image) {
                        $("#gallery-images").append(`
                                <a href="#" class="image-populate" data-image-url="${image.link}" id="image-${image.id}" data-in-image-list="false">
                                        <div class="w-[290px] m-2 relative overflow-hidden">
                                            <i class="fa-sharp fa-solid fa-circle-check text-green-700 absolute top-3 right-3" hidden></i>
                                            <div class="absolute bottom-0 left-0">
                                                <div class="viewData  text-gray-500">a
                                                    <div class="text-xs p-1 viewItem">
                                                        <div class="label">Host</div>
                                                        <div class="data">
                                                            ${image.imageUrl['scheme']}://${image.imageUrl['host'] }
                                                        </div>
                                                    </div>
                                                    <div class="text-xs px-1 pb-3 viewItem">
                                                        <div class="label">Path</div>
                                                        <div class="data">
                                                            ${image.imagePath['dirname'] }/
                                                        </div>
                                                    </div>
                                                    <div class="text-xs px-1 viewItem">
                                                        <div class="label">Name</div>
                                                        <div class="data">
                                                            ${image.imagePath['filename']}.${image.imagePath['extension']}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="w-[300px] h-[300px]">
                                                <img src="${image.link}" alt="image" class="w-full h-full" style="object-fit: cover">
                                            </div>
                                        </div>
                                    </a>
                        `);
                    });
                    if(groupId && !current) {
                        //$("nav li[data-group='" + groupId + "']").addClass("bg-blue-500 text-white");
                        let group = $(`nav li:has(a[data-group="${groupId}"])`);
                        group.addClass("bg-blue-500 text-white");
                        let title = group.text();
                        $('#image-group-title').text(title);
                    }
                    setCheckmarkGalleryImages();

                    if (current) {
                        $('[data-in-image-list="false"]').hide();
                        $('nav li:has(a[data-group="current"])').addClass("bg-blue-500 text-white");
                        $('#image-group-title').text(`In Current Project`);
                    }
                }
            });
        })
    });
</script>

@endpush




