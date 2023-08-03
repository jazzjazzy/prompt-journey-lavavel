<?php $isDashboardPage = true; ?>
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

                        @if (isset($suffix))

                        <form action="" method="post">
                            @csrf
                            <input id="suffix-link" type="hidden" value="{{$suffix}}"/>
                            <div class="grid grid-cols-12">
                                <h3 class="col-span-12 mx-3">Suffix Text</h3>
                                <textarea class="border bg-slate-100 border-slate-400 col-span-12 p-3 mx-3 mb-3">{{$suffix}}</textarea>
                                @if (isset($projectId) && $projectId !== null)

                                <div class="col-span-12">
                                    <div class="card m-3 mt-0">
                                        <div class="grid grid-cols-12 gap-3 card-body pt-0">
                                            <div class="col-span-6">
                                                <div class="grid grid-cols-12 mb-3 flex items-center">
                                                    <label class="col-span-3 text-gray-600" for="stop">Title</label>
                                                    <div class="col-span-9">
                                                        <input type="text" id="suffix-title" class="parameter-class"
                                                               value="{{$suffixName}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-span-6">
                                                <div class="grid grid-cols-12 flex items-center">
                                                    <label class="col-span-3 text-gray-600" for="style">Add to
                                                        group</label>
                                                    <div class="col-span-9">
                                                        <input id="add-to-group"
                                                               class="parameter-class w-full"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-footer grid grid-cols-12">
                                            <div class="col-span-8">
                                                <div class="alert alert-success hidden" id="suffix-save-notice">
                                                    suffixs copied to clipboard
                                                </div>
                                            </div>
                                            <div class="col-span-4 footer-right">
                                                <input type="hidden" name="row_id" id="row-suffix-id" value="" data-row-suffix-id="{{$buttonRow}}">
                                                <button class="btn btn-primary" id="save-suffixes">Add to suffixes
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </form>
                    </div>
                    @else
                    <div class="h-[15rem] w-[15rem] border-2 flex justify-center items-center">No Suffix</div>
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

        $('#save-suffixes').on('click', (e) => {
            e.preventDefault();
            saveSuffixes();
        });

        function saveSuffixes() {
            var select = $('#add-to-group').selectize();
            var selectize = select[0].selectize;
            var projectId = $('#projectId').val();
            var rowIndex = $('#row-suffix-id').data('row-suffix-id');

            const createEnabled = selectize.getValue();

            let promptArray = {
                "suffix": $('#suffix-link').val(),
                "title": $('#suffix-title').val(),
                "group": createEnabled,
            };

            //todo: look into getting the url from route() maybe the data-url attribute
            $.ajax({
                url: `/suffix/` + projectId + `/save`,
                type: 'POST',
                data: promptArray,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        suffixNoticeAlert('#suffix-save-notice', 'Suffix Text has been saved to your list.');
                        // Send the row ID back to the parent window
                        window.parent.postMessage({ type: 'suffix', elementId: response.suffixId, rowIndex: 'row-view-suffix-' + rowIndex }, '*');
                    } else {
                        alert('Error adding suffix.');
                    }
                },
                error: function (xhr, status, error) {
                    alert('An error occurred while adding suffix.');
                    console.log(error + ' ' + status + ' ' + xhr.responseText);
                }
            });
        }
    });
</script>
