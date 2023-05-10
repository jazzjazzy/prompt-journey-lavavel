<?php $isDashboardPage = true; ?>
@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 pt-1 m-auto px-12">
    @if (isset($projectId) && $projectId !== null)
    <input type="hidden" value="{{$projectId}}" name="projectId" id="projectId">
    @endif
    <div class="col-span-10 border-3 border-l-gray-400 border-r-gray-300 border-t-gray-400 border-b-gray-300 relative">
        {{-- copy massage --}}
        <div class="alert alert-success mx-3 absolute bottom-0 right-0 w-fit " id="copy-mj-prompt">
            suffix copied to clipboard
        </div>
        {{-- history past --}}
        <div id="pre-prompt-2"
             class="w-full text-xs align-middle bg-gradient-to-t from-gray-300 bg-gray-200text-gray-300 h-6 pl-4 w-3/4 truncate"></div>
        <div id="pre-prompt-1"
             class="w-full text-sm align-middle bg-gradient-to-t from-gray-400 bg-gray-300 text-gray-600 h-6 pl-4 w-3/4 truncate"></div>

        {{-- *********************** --}}
        {{-- This is the main prompt --}}
        {{-- *********************** --}}
        <div class="p-0 m-0 grow-wrap bg-gray-400">
            <label for="prompt"></label><textarea
            class="focus:outline-none w-full h-16 resize-none border border-gray-300 bg-gray-400 rounded-md px-4 py-2 bg-white col-span-full"
            disabled
            id="prompt" >
        </textarea>
        </div>
        {{-- history future --}}
        <div id="post-prompt-1"
             class="w-full text-sm align-middle bg-gradient-to-b from-gray-400 bg-gray-300 text-gray-600 h-6 pl-4 w-3/4 truncate"></div>
        <div id="post-prompt-2"
             class="w-full text-xs align-middle bg-gradient-to-b from-gray-300 bg-gray-200 text-gray-300 h-6 pl-4 w-3/4 truncate"></div>

    </div>
    <div class="col-span-2">
        {{-- Main prompt copy button --}}
        <button id="copyMjButton" title="Ctrl + shift + c" class="btn btn-primary mt-3 mx-4 h-fit w-fit">
            <i class="text-[90px] p-4 fas fa-copy"></i>
        </button>
    </div>
</div>
<div class="mx-12 mt-1">
    <div class="grid grid-cols-10">
        <div id="text-field" class="p-2 col-span-7 bg-gradient-to-r from-gray-100 bg-gray-300 overflow-auto">
            <div class="grid grid-cols-12 gap-2">
                <div class="col-span-10">
                    <div class="card">
                        <div class="card-header">
                            <h2>Prompts</h2>
                        </div>

                        <div class="card-body">
                            <div class="input-prompt-fields">
                                <div class="grid grid-cols-12 gap-2">
                                    <div class="col-span-12 grow-wrap">

                                        {{-- ************************************** --}}
                                        {{-- This is the input field for the prompt --}}
                                        {{-- ************************************** --}}
                                        <textarea name="text" id="prompt-text"
                                                  onInput="$.expandTextarea(this)"
                                                  class="prompt-text-class mt-0 w-full overflow-auto" type="text"
                                                  title="ctrl-space"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-2">
                    <div class="card">
                        <div class="card-header">
                            <h2>Actions</h2>
                        </div>
                        <div class="card-body -mt-4">
                            <div class="card p-0 m-0">
                                <div class="grid grid-cols-12 gap-1 p-0 m-0">
                                    <div
                                        class="text-gray-100 w-full bg-gray-900 rounded-t-md col-span-12 flex items-center justify-center p-0 m-0">
                                        Add as Suffix
                                    </div>
                                    <div class="px-1 pb-1 col-span-12 gap-1 flex items-center justify-center">
                                        <button id="add-to-suffix-list"
                                                class="btn btn-primary col-span-6 m-0 p-1 w-full">
                                            All
                                        </button>
                                        <button id="pramas-to-suffix-list"
                                                class="btn btn-primary col-span-6 m-0 p-1 w-full">
                                            Params
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <button id="clear" class="btn btn-primary m-0 mt-2 w-full">
                                Clear
                            </button>
                            <button id="show-history" class="btn btn-primary m-0 mt-2 w-full">
                                show History
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="basic-params" class="card p-0">
                <div class="card-header bg-gradient-to-r from-green-100 to-green-700">
                    <h2>Basic Parameters</h2>
                </div>
                <div class="card-body p-0 m-0">
                    <div class="grid grid-cols-4 gap-2 mt-5 p-2">
                        <div id="aspect-wrapper" data-color="green" class="bg-green-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-600" for="aspect">--aspect</label>
                                <div class="col-span-8">
                                    <select id="aspect" class="parameter-class w-full"></select>
                                </div>
                            </div>
                        </div>
                        <div id="chaos-wrapper" data-color="green" class="bg-green-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-600" for="chaos">--chaos</label>
                                <div class="col-span-8">
                                    <input type="text" id="chaos" class="parameter-class">
                                </div>
                            </div>
                        </div>
                        <div id="quality-wrapper" data-color="green" class="bg-green-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-600" for="aspect">--quality</label>
                                <div class="col-span-8">
                                    <label for="quality"></label><select id="quality"
                                                                         class="parameter-class w-full"></select>
                                </div>
                            </div>
                        </div>
                        <div id="no-wrapper" data-color="green" class="bg-green-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-600" for="no">--no</label>
                                <div class="col-span-8">
                                    <input type="text" id="no" class="parameter-class">
                                </div>
                            </div>
                        </div>
                        <div id="seed-wrapper" data-color="green" class="bg-green-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-600" for="seed">--seed</label>
                                <div class="col-span-8">
                                    <input type="text" id="seed" class="parameter-class">
                                </div>
                            </div>
                        </div>
                        <div id="stop-wrapper" data-color="green" class="bg-green-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-600" for="stop">--stop</label>
                                <div class="col-span-8">
                                    <input type="text" id="stop" class="parameter-class">
                                </div>
                            </div>
                        </div>
                        <div id="style-wrapper" data-color="green" class="bg-green-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-600" for="style">--style</label>
                                <div class="col-span-8">
                                    <select id="style" class="parameter-class w-full"></select>
                                </div>
                            </div>
                        </div>
                        <div id="version-wrapper" data-color="green" class="bg-green-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-600" for="version">--version</label>
                                <div class="col-span-8">
                                    <select id="version" class="parameter-class w-full"></select>
                                </div>
                            </div>
                        </div>
                        <div id="stylize-wrapper" data-color="green" class="bg-green-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-600" for="stylize">--stylize</label>
                                <div class="col-span-8">
                                    <input type="number" id="stylize" class="parameter-class w-full">
                                </div>
                            </div>
                        </div>
                        <div id="iw-wrapper" data-color="green" class="bg-green-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-600" for="iw">--iw</label>
                                <div class="col-span-8">
                                    <input type="number" id="iw" class="parameter-class">
                                </div>
                            </div>
                        </div>
                        <div id="tile-wrapper" data-color="green" class="bg-green-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-600" for="tile">--tile</label>
                                <div class="col-span-8">
                                    <input type="checkbox" id="tile" class="parameter-class">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="model-params" class="card p-0">
                <div class="card-header bg-gradient-to-r from-blue-100 to-blue-700">
                    <h2>Model Version Parameters</h2>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-4 gap-2 mt-5 p-2">
                        <div id="niji-wrapper" data-color="sky" class="bg-sky-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-600" for="niji">--niji</label>
                                <div class="col-span-8">
                                    <input type="checkbox" id="niji" class="parameter-class">
                                </div>
                            </div>
                        </div>
                        <div id="hd-wrapper" data-color="sky" class="bg-sky-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-600" for="hd">--hd</label>
                                <div class="col-span-8">
                                    <input type="checkbox" id="hd" class="parameter-class">
                                </div>
                            </div>
                        </div>
                        <div id="test-wrapper" data-color="sky" class="bg-sky-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-600" for="test">--test</label>
                                <div class="col-span-8">
                                    <input type="checkbox" id="test" class="parameter-class">
                                </div>
                            </div>
                        </div>
                        <div id="testp-wrapper" data-color="sky" class="bg-sky-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-600" for="testp">--testp</label>
                                <div class="col-span-8">
                                    <input type="checkbox" id="testp" class="parameter-class">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div id="upscaler-params" class="upscaler-params card p-0">
                <div class="card-header bg-gradient-to-r from-pink-300 to-pink-600 bg-pink-700">
                    <h2>Upscaler Parameters</h2>
                </div>
                <div class="card-body ">
                    <div class="grid grid-cols-4 gap-2 mt-5 p-2">
                        <div id="uplight-wrapper" data-color="pink" class="bg-pink-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-600" for="uplight">--uplight</label>
                                <div class="col-span-8">
                                    <input type="checkbox" id="uplight" class="parameter-class">
                                </div>
                            </div>
                        </div>
                        <div id="upbeta-wrapper" data-color="pink" class="bg-pink-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-600" for="upbeta">--upbeta</label>
                                <div class="col-span-8">
                                    <input type="checkbox" id="upbeta" class="parameter-class">
                                </div>
                            </div>
                        </div>
                        <div id="upanime-wrapper" data-color="pink" class="bg-pink-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-600" for="upanime">--upanime</label>
                                <div class="col-span-8">
                                    <input type="checkbox" id="upanime" class="parameter-class">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-2 col-span-3 bg-gradient-to-l from-gray-100 bg-gray-300">
            <div id="suffix" class="card">
                <div class="card-header">
                    <h2>suffix</h2>
                </div>
                <div class="card-body">
                    <div id="input-suffix-fields">
                        <div class="flex mt-2">
                            <span class="handle my-auto cursor-grab">&#9776;</span>
                            <div class="flex-none px-3">
                                <label for="suffix-add-1"></label><input type="checkbox" name="suffixAdd-1"
                                                                         id="suffix-add-1" class="suffix-add">
                            </div>
                            <div class="grow">
                                <label for="suffix-input-1"></label><input type="text" name="suffix-1"
                                                                           id="suffix-input-1" autocomplete="off"
                                                                           class="suffix-input disabled:text-gray-400 disabled:border-green-700">
                            </div>
                            @php
                            $route = isset($projectId) && $projectId !== null ? route('modals.suffix', ['project' =>
                            $projectId]) : route('modals.suffix');
                            @endphp

                            {{-- if user don't have suffix access then create route createDynamicSuffixRow in suffix.js --}}
                            @if ($user->accessLevels->suffix !== true)
                                @php
                                    $subSuffixMessage = 'You do not have access to suffixes. Please subscribe to a plan that includes suffixes.';
                                    $route = route('subscription.pricing.modal', ['message' => $subSuffixMessage]);
                                @endphp
                                <input type="hidden" id="is-suffix" value="{{ $route }}">
                            @endif

                            <div class="flex-none px-3">
                                @if($user->accessLevels->suffix)
                                    <button id="row-view-suffix-1" class="icon-button show-suffix" title="View Suffix" data-modal-size="sm"
                                            data-url="{{ $route }}"
                                            data-suffix-id>
                                        <i class="fa-sharp fa-solid fa-align-right"></i>
                                    </button>
                                @else
                                    <button id="row-view-suffix-1" class="open-modal icon-button-disabled " title="Suffix List"
                                            data-modal-size="xl" data-url="{{ route('subscription.pricing.modal', ['message' => $subSuffixMessage]) }}">
                                        <i class="fa-sharp fa-solid fa-align-right"></i>
                                    </button>
                                @endif
                                <button id="row-copy-suffix-1" class="icon-button suffix-input-copy" title="copy suffix">
                                    <i class="fas fa-copy"></i>
                                </button>
                                <button id="row-delete-suffix-1" class="icon-button suffix-input-delete" title="delete suffix">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="grid grid-cols-2">
                        <div class="flex content-start items-center">
                            <div class="alert alert-success" id="suffix-notice">suffix copied to clipboard
                            </div>
                        </div>
                        <div class="flex content-end flex-row-reverse">
                            <button class="add-suffix btn btn-primary">Add suffix</button>
                                @if ($user->accessLevels->suffix === true)
                                <button id="" class="open-modal btn btn-primary" title="Suffix List" data-modal-size="lg"
                                        data-modal-fixed=true
                                        data-url="{{ route('suffixes.view') }}">
                                    suffix List
                                </button>
                                @else
                                <button id="suffix-list" class="open-modal btn btn-primary-disabled text-center" title="Suffix List"
                                   data-modal-size="xl" data-url="{{ $route }}">
                                    Suffix List
                                </button>
                                @endif

                        </div>
                    </div>
                </div>
            </div>
            <div id="images" class="card">
                <div class="card-header">
                    <h2>Image Links</h2>
                </div>
                <div class="card-body">
                    <div id="input-image-fields">
                        <div class="flex mt-2">
                            <span class="handle my-auto cursor-grab">&#9776;</span>
                            <div class="flex-none px-3">
                                <label for="images-add-1"></label><input type="checkbox" name="imagesAdd-1"
                                                                         id="images-add-1" class="images-add">
                            </div>
                            <div class="grow">
                                <label for="images-input-1"></label><input type="text" name="images-1"
                                                                           id="images-input-1" autocomplete="off"
                                                                           class="images-input disabled:text-gray-400 disabled:border-green-700">
                            </div>
                            @php
                            $route = isset($projectId) && $projectId !== null ? route('modals.images', ['project' =>
                            $projectId]) : route('modals.images');
                            @endphp
                            <div class="flex-none px-3">
                                <button id="row-view-image-1" class="icon-button show-image" title="View images" data-modal-size="lg"
                                        data-url="{{ $route }}" data-image-id>
                                    <i class="fas fa-image"></i>
                                </button>
                                <button id="row-copy-image-1" class="icon-button images-input-copy">
                                    <i class="fas fa-copy"></i>
                                </button>
                                <button id="row-delete-image-1" class="icon-button images-input-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="grid grid-cols-2">
                        <div class="flex content-start items-center">
                            <div class="alert alert-success" id="images-notice">
                                images copied to clipboard
                            </div>

                        </div>
                        <div class="flex content-end flex-row-reverse">
                            <button class="add-images btn btn-primary">Add image</button>
                            @if ($user->accessLevels->images === true)
                            <button id="" class="btn btn-primary open-modal" title="Images Gallery" data-modal-size="xl"
                                    data-modal-fixed=true data-url="{{ route('gallery.view') }}">
                                Images gallery
                            </button>
                            @else
                                @php
                                    $subImageMessage = 'Subscribe to Pro account to access Images Gallery package.';
                                @endphp
                            <button id="" class="open-modal btn btn-primary-disabled text-center" title="Images Gallery"
                               data-modal-size="xl" data-url="{{ route('subscription.pricing.modal', $subImageMessage) }}">
                                Images gallery
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @include('shortcuts')
        </div>
    </div>


    <div id="overlayContainer"></div>

    <div id="overlayHistory" class="hidden">
        <div class="overlay w-full">
            <div class="card bg-gray-100 p-0 w-3/4">
                <div class="mx-auto">
                    <h2 class="card-header text-2xl font-bold mb-4">Prompt History</h2>
                    <div id="overlayContent" class="card-body -m-3 flex flex-col h-full">
                        <!-- history content goes here in #overlayContent -->
                    </div>
                    <div class="card-footer footer-right !mt-0 p-2">
                        <button class="close-btn btn btn-primary px-4 ml-2 mt-2 self-star">
                            Close
                        </button>
                        <button id="clear-history" class="btn btn-primary py-2 px-4 ml-2 mt-2 self-start">
                            Clear History
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('script')
    <script type="module">
        $(document).ready(function () {
            $('.popup-youtube').magnificPopup({
                type: 'iframe'
            });
        });
    </script>

    {{-- remove this on local as it is announcing when working on pages --}}
    {{-- also only do this ig the user is free plan as they can't save prompts --}}
    @if (env('APP_ENV') === 'production' && $user->accessLevels->plan === 'Free')
    <script type="module">
        $(document).ready(function () {
            $(window).bind('beforeunload', function () {
                return 'Are you sure you want to leave? all current data will be lost';
            });
        });
    </script>
    @endif

    <script type="module">
        $(document).ready(function () {

            retrieveProjectHistory();

            $('#prompt-text').on('keyup', function () {
                updatePromptAllFields();
            });

            $(document).on('focus', '#prompt', function () {
                if ($(this).is(':disabled')) {
                    $('#prompt-text').focus(); // shift focus to prompt-text
                }
            });

            $('#prompt').prop('disabled', true); // disable prompt

            // Listen for an event from the iframe page when the Ajax call is completed
            window.addEventListener('message', function(event) {
                if (event.data && event.data.elementId && event.data.rowIndex) {
                    const { type, elementId, rowIndex } = event.data;
                    console.log(event.data);
                    $('#'+ rowIndex).attr('data-'+ type +'-id', elementId);
                }
            }, false);
        });
    </script>
    @endsection

