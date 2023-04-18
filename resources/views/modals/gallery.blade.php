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
                                    @foreach ($groups as $group)
                                        <button class="btn btn-primary w-full group-details" data-group="{{$group->id}}">{{$group->name}}
                                        </button>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            <div class="col-span-10 overflow-y-auto flex-1 mb-5">
                                @if (isset($images) && $images !== null)
                                <div id="gallery-images" class="flex flex-wrap">
                                    @foreach ($images as $image)

                                    <a href="#" class="image-populate" data-image-url="{{$image->link}}" id="image-{{$image->id}}">
                                        <div class="w-[290px] m-2 relative overflow-hidden">
                                            <i class="fa-sharp fa-solid fa-circle-check text-green-700 absolute top-3 right-3" hidden></i>
                                            <div class="absolute bottom-0 left-0">
                                                <div class="viewData  text-gray-500">a
                                                    <div class="text-xs p-1 viewItem">
                                                        <div class="label">Host</div>
                                                        <div class="data">
                                                            {{ $image->imageUrl['scheme'] }}://{{$image->imageUrl['host'] }}
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
                                                            {{ $image->imagePath['filename']}}.{{$image->imagePath['extension']}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <img src="{{$image->link}}" alt="image" class="w-full h-auto">
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

            addToImageList(url, idname);
        });


        $('.group-details').on('click', function () {


            let groupId = $(this).data('group');
            let projectId = $('#projectId').val();
            console.log(groupId);
            $.ajax({
                url: `/gallery/${groupId}`,
                type: 'GET',
                success: function (data) {
                    $('#gallery-images').html('');
                    data.images.forEach(function (image) {
                        $('#gallery-images').append(`
                                <a href="#" class="image-populate" data-image-url="{{$image->link}}" id="image-${image.id}">
                                        <div class="w-[290px] m-2 relative overflow-hidden">
                                            <i class="fa-sharp fa-solid fa-circle-check text-green-700 absolute top-3 right-3" hidden></i>
                                            <div class="absolute bottom-0 left-0">
                                                <div class="viewData  text-gray-500">a
                                                    <div class="text-xs p-1 viewItem">
                                                        <div class="label">Host</div>
                                                        <div class="data">
                                                            {{ $image->imageUrl['scheme'] }}://{{$image->imageUrl['host'] }}
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
                                                            {{ $image->imagePath['filename']}}.{{$image->imagePath['extension']}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <img src="${image.link}" alt="image" class="w-full h-auto">
                                        </div>
                                    </a>
                        `);
                    });
                    setCheckmarkGalleryImages();
                }
            });
        })
    });
</script>

@endpush




