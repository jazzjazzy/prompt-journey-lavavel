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
                                        <ul>
                                            @foreach ($groups as $group)
                                            <li class="group-item w-full cursor-pointer group-details"
                                                data-group="{{$group->id}}">
                                                <a class="w-full group-details" data-group="{{$group->id}}">
                                                    {{$group->name}}
                                                </a>
                                            </li>
                                            @endforeach
                                            <li class="group-item w-full cursor-pointer group-details"
                                                data-group="all">
                                                <a class="w-full group-details" data-group="all">
                                                    All
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                                @endif
                            </div>
                            <div class="col-span-10 overflow-y-auto flex-1 mb-5">
                                @if (isset($suffixes) && $suffixes !== null)
                                <div id="gallery-suffixes" class="w-full">
                                    @foreach ($suffixes as $suffix)

                                    <a href="#" class="suffix-populate" data-suffix-url="{{$suffix->suffix}}"
                                       id="suffix-{{$suffix->id}}">
                                        <div class="m-2 relative overflow-hidden">
                                            <i class="fa-sharp fa-solid fa-circle-check text-green-700 absolute top-2 right-6"
                                               hidden></i>
                                            <div class="border bg-slate-100 border-slate-400 col-span-12 p-3 mx-3 mb-3">
                                                {{$suffix->suffix}}
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

        setCheckmarkListSuffix();

        $(document).on('click', '.modal .suffix-populate', function () {
            let url = $(this).data('suffix-url');
            let idname = $(this).attr('id');

            addToSuffixModalList(url, idname);
        });


        $('.group-details').on('click', function () {
            $("nav li").removeClass("bg-blue-500 text-white");

            let groupId = $(this).data('group');
            let projectId = $('#projectId').val();

            $.ajax({
                url: `/suffixes/list/${groupId}`,
                type: 'GET',
                success: function (data) {
                    $('#gallery-suffixes').html('');
                    data.suffixes.forEach(function (suffix) {
                        $('#gallery-suffixes').append(`
                                <a href="#" class="suffix-populate" data-suffix-url="${suffix.suffix}" id="suffix-${suffix.id}">
                                        <div class="m-2 relative overflow-hidden">
                                            <i class="fa-sharp fa-solid fa-circle-check text-green-700 absolute top-2 right-6"
                                               hidden></i>
                                            <div class="border bg-slate-100 border-slate-400 col-span-12 p-3 mx-3 mb-3">
                                                ${suffix.suffix}
                                            </div>
                                        </div>
                                    </a>
                        `);
                    });
                    if (groupId)
                        $("nav li[data-group='" + groupId + "']").addClass("bg-blue-500 text-white");
                    setCheckmarkListSuffix();
                }
            });
        })
    });
</script>

@endpush




