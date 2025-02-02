@extends('layouts.modal')

@section('content')
<div>
    @if (isset($projectId) && $projectId !== null)
    <input type="hidden" value="{{$projectId}}" name="projectId" id="projectId">
    @endif
    @if (isset($groupOption) && $groupOption !== null)
    <input type="hidden" value="{{$groupOption}}" name="group-options" id="group-options">
    @endif
    @if (isset($groupsSelected) && $groupsSelected !== null)
    <input type="hidden" value="{{$groupsSelected}}" name="group-options-selected" id="group-options-selected">
    @endif
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body flex justify-center">
                    <div class="p-5">
                        @if (isset($image) && filter_var($image, FILTER_VALIDATE_URL))

                        <form action="" method="post">
                            @csrf
                            <input id="image-link" type="hidden" value="{{$image}}"/>
                            <div class="grid grid-cols-12">
                                @if (isset($projectId) && $projectId !== null && $user->accessLevels->images == true)
                                <div class="col-span-5">
                                    <div class="pl-0 pb-3">
                                        <div class="  border-2">
                                            <img id="image-preview" class="w-full" src="{{$image}}"
                                                 alt="Image Preview">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-7 grow">
                                    <div class="card m-3 mt-0">
                                        <div class="card-body pt-0">
                                            <div class="grid grid-cols-12 mb-3 flex items-center">
                                                <label class="col-span-3 text-gray-600" for="stop">Title</label>
                                                <div class="col-span-9">

                                                    <input type="text" id="image-title" class="parameter-class" value="{{$imagesName}}">
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-12 flex items-center">

                                                <label class="col-span-3 text-gray-600" for="style">Add to
                                                    group</label>
                                                <div class="col-span-9">
                                                    <input id="add-to-group"
                                                           class="parameter-class w-full" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-footer grid grid-cols-12">
                                            <div class="col-span-8">
                                                <div class="alert alert-success hidden" id="image-save-notice">
                                                    images copied to clipboard
                                                </div>
                                            </div>
                                            <div class="col-span-4 footer-right">
                                                <input type="hidden" name="row_id" id="row-image-id" value="" data-row-image-id="{{$buttonRow}}">
                                                <button class="btn btn-primary" id="save-images">Add to gallery</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="col-span-5">
                                    <div class="pl-0 pb-3 h-1/2">
                                        <div class="h-[19rem] w-[19rem] border-2">
                                            <img id="image-preview" class="h-[19rem]" style="object-fit: cover" src="{{$image}}"
                                                 alt="Image Preview">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-7">
                                    <div class="viewData">
                                        <div class="text-xs p-3 viewItem">
                                            <div class="label">Host</div>
                                            <div class="data">
                                                <a href="{{$image}}" target="_blank">{{ $imageUrl['scheme']
                                                    }}://{{$imageUrl['host']
                                                    }}</a>
                                            </div>
                                        </div>
                                        <div class="text-xs px-3 pb-3 viewItem">
                                            <div class="label">Path</div>
                                            <div class="data">
                                                <a href="{{$image}}" target="_blank">{{ $imagePath['dirname'] }}/</a>
                                            </div>
                                        </div>
                                        <div class="text-xs px-3 viewItem">
                                            <div class="label">Name</div>
                                            <div class="data">
                                                <a href="{{$image}}" target="_blank">{{
                                                    $imagePath['filename']}}.{{$imagePath['extension']}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </form>
                        @if ((isset($projectId) && $projectId !== null) && $user->accessLevels->images == true)
                        <div class="viewData">
                            <div class="text-xs p-3 viewItem">
                                <div class="label">Host</div>
                                <div class="data">
                                    <a href="{{$image}}" target="_blank">{{ $imageUrl['scheme'] }}://{{$imageUrl['host']
                                        }}</a>
                                </div>
                            </div>
                            <div class="text-xs px-3 pb-3 viewItem">
                                <div class="label">Path</div>
                                <div class="data">
                                    <a href="{{$image}}" target="_blank">{{ $imagePath['dirname'] }}/</a>
                                </div>
                            </div>
                            <div class="text-xs px-3 viewItem">
                                <div class="label">Name</div>
                                <div class="data">
                                    <a href="{{$image}}" target="_blank">{{
                                        $imagePath['filename']}}.{{$imagePath['extension']}}</a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="h-[15rem] w-[15rem] border-2 flex justify-center items-center">No Image</div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script type="module">

    $(document).ready(function () {

        let options = $('#group-options').val() ? JSON.parse($('#group-options').val() ) : [];
        let selected = $('#group-options-selected').val() ? JSON.parse($('#group-options-selected').val() ) : [];
        $('#add-to-group').selectize({
            options: options,
            plugins: ['remove_button'],
            valueField: 'value',
            labelField: 'text',
            searchField: 'text',
            create: true,
            dropdownParent: 'body',
            delimiter: '-::-',
            render: {
                option: function (data, escape) {
                    return '<div class="px-4 py-2 hover:bg-gray-900">' + escape(data.text) + '</div>';
                },
                item: function (data, escape) {
                    return '<div class="p-0">' + escape(data.text) + '</div>';
                }
            },
            onChange: function(value) {
                if (value !== '') {
                    this.close();
                }
            },
            items: selected,

        });

        $('#save-images').on('click', (e) => {
            e.preventDefault();
            saveImages();
        });

        function saveImages() {
            var select = $('#add-to-group').selectize();
            var selectize = select[0].selectize;
            var projectId = $('#projectId').val();
            var rowIndex = $('#row-image-id').data('row-image-id');

            const createEnabled = selectize.getValue();

            let promptArray = {
                "link": $('#image-link').val(),
                "title": $('#image-title').val(),
                "group": createEnabled,
            };

            $.ajax({
                url: `/images/` + projectId + `/save`,
                type: 'POST',
                data: promptArray,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        imageNoticeAlert('#image-save-notice', 'Image link has been saved to your gallery.');

                        window.parent.postMessage({ type: 'image', elementId: response.imageId, rowIndex: 'row-view-image-' + rowIndex }, '*');
                    } else {
                        alert('Error adding image to gallery.');
                    }
                },
                error: function (xhr, status, error) {
                    alert('An error occurred while adding Images Details.');
                    console.log(error + ' ' + status + ' ' + xhr.responseText);
                }
            });
        }

    });
</script>


