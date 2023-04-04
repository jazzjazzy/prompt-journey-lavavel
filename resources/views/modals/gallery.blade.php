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
                    <div class="grid grid-cols-5 overflow-hidden">
                        <div class="col-span-1 overflow-y-auto">
                            @if (isset($groups) && $groups !== null)
                            <div class="h-full">
                                @foreach ($groups as $group)
                                <div class="w-full">
                                    <button class="w-full group-details" data-group="{{$group->id}}">{{$group->name}}
                                    </button>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        <div class="col-span-4 overflow-y-auto">

                            @if (isset($images) && $images !== null)
                            <div id="gallery-images" class="flex flex-wrap">
                                @foreach ($images as $image)
                                <div class="w-1/4 m-0 relative overflow-clip">
                                    <div class="absolute bottom-0 left-0 m-1">
                                        <div class="viewData  text-gray-500">
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
                                                    {{ $image->imagePath['filename']}}.{{$image->imagePath['extension']
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <img src="{{$image->link}}" alt="image" class="w-full h-auto">
                                </div>
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
@endsection

@push('scripts')
<script type="module">
    $(document).ready(function () {

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
                            <div class="w-1/4 m-2 relative">
                                <div class="absolute bottom-0 left-0">
                                         <div class="viewData  text-gray-500">
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
                                    {{ $image->imagePath['filename']}}.{{$image->imagePath['extension'] }}
                                </div>
                            </div>
                        </div>
                                </div>
                                <img src="${image.link}" alt="image" class="w-full h-auto">
                            </div>
                        `);
                    });
                }
            });
        })
    });
</script>

@endpush




