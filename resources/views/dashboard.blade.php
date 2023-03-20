@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 pt-1 m-auto px-12">
    <div class="col-span-10 border-black border-4">
        {{-- history past --}}
        <div id="pre-prompt-2" class="text-xs align-middle text-gray-300 h-6 pl-4 w-3/4 truncate"></div>
        <div id="pre-prompt-1" class="text-sm align-middle text-gray-600 h-6 pl-4 w-3/4 truncate"></div>

        {{-- *********************** --}}
        {{-- This is the main prompt --}}
        {{-- *********************** --}}
        <div class="p-0 m-0 grow-wrap">
        <textarea
            class="focus:outline-none w-full h-16 resize-none border border-gray-300 rounded-md px-4 py-2 bg-white col-span-full"
            disabled
            id="prompt">
        </textarea>
        </div>
        {{-- history future --}}
        <div id="post-prompt-1" class="text-sm align-middle text-gray-600 h-6 pl-4 w-3/4 truncate"></div>
        <div id="post-prompt-2" class="text-xs align-middle text-gray-300 h-6 pl-4 w-3/4 truncate"></div>
    </div>
    <div class="col-span-2">

        <button id="copyMjButton" title="Ctrl + shift + c" class="btn btn-primary mt-3 mx-4 h-fit w-fit">
            <i class="text-[130px] p-4 fas fa-copy"></i>
        </button>
        {{-- Main prompt copy button --}}
        <div class="alert alert-notice mx-3 hidden" id="copy-mj-prompt">
            suffix copied to clipboard
        </div>
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
                        <div class="card-body">
                            <div>

                                <div class="card p-0 m-0">

                                        <div class="grid grid-cols-12 gap-1 p-1 m-0">
                                            <div class="w-full bg-gray-300 col-span-12 flex items-center justify-center p-0 m-0">Add as Suffix</div>
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
            </div>

            <div class="card p-0">
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
                                    <select id="quality" class="parameter-class w-full"></select>
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
                                    <input type="text" id="stylize" class="parameter-class w-full">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card p-0">
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
            <div class="card p-0">
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
                                <input type="checkbox" name="suffixAdd[]" class="suffix-add">
                            </div>
                            <div class="grow">
                                <input type="text" name="suffix[]" class="suffix-input disabled:text-gray-600">
                            </div>
                            <div class="flex-none px-3">
                                <button class="icon-button suffix-input-copy">
                                    <i class="fas fa-copy"></i>
                                </button>
                                <button class="icon-button suffix-input-delete">
                                    <i class="fas fa-trash"></i>
                                </button
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="grid grid-cols-2">
                    <div class="flex content-start items-center">
                        <div class="alert alert-notice hidden" id="suffix-notice">
                            suffix copid to clipboard
                        </div>
                    </div>
                    <div class="flex content-end flex-row-reverse">
                        <button class="add-suffix btn btn-primary">Add suffix link</button>
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
                    <div class="flex">
                        <div class="flex-none px-3">
                            <input type="checkbox" name="imagesAdd[]" class="images-add">
                        </div>
                        <div class="grow">
                            <input type="text" name="images[]" class="images-input disabled:text-gray-600">
                        </div>
                        <div class="flex-none px-3">
                            <button class="icon-button show-image">
                                <i class="fas fa-image"></i>
                            </button>
                            <button class="icon-button images-input-copy">
                                <i class="fas fa-copy"></i>
                            </button>
                            <button class="icon-button images-input-delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="grid grid-cols-2">
                    <div class="flex content-start items-center">
                        <div class="alert alert-notice hidden" id="images-notice">
                            suffix copied to clipboard
                        </div>
                    </div>
                    <div class="flex content-end flex-row-reverse">
                        <button class="add-images btn btn-primary">Add image link</button>
                    </div>
                </div>
            </div>
        </div>
        @include('shortcuts')
    </div>
</div>


<div id="overlayContainer"></div>

<div id="overlayHistory"></div>
@endsection

@section('script')
<script type="module">
    $(document).ready(function () {
        $('.popup-youtube').magnificPopup({
            type: 'iframe'
        });
    });
</script>

<script type="module">


    $(document).ready(function () {

        $('#prompt-text').on('keyup', function () {
            aspectParam();
            chaosParam();
            qualityParam();
            noParam();
            seedParam();
            stopParam();
            styleParam();
            stylizeParam();
            versionParam();
            nijiParam();
            hdParam();
            testParam();
            testpParam();
            uplightParam();
            upbetaParam();
            upanimeParam();

        });

        $(document).on('focus', '#prompt', function () {
            if ($(this).is(':disabled')) {
                $('#prompt-text').focus(); // shift focus to textarea2
            }
        });

        $('#prompt').prop('disabled', true); // disable textarea1
    });
</script>
@endsection

