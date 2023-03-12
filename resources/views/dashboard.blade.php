@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 py-3">
    <div class="col-span-10 border-black border-4">
        <div id="pre-prompt-2" class="text-xs align-middle text-gray-300 h-6 pl-4"></div>
        <div id="pre-prompt-1" class="text-sm align-middle text-gray-400 h-6 pl-4"></div>
        <textarea
            class="disabled: focus:outline-none w-full h-24 resize-none border border-gray-300 rounded-md px-4 py-2 bg-white col-span-full"
            id="prompt"></textarea>
        <div id="post-prompt-1" class="text-sm align-middle text-gray-400 h-6 pl-4"></div>
        <div id="post-prompt-2" class="text-xs align-middle text-gray-300 h-6 pl-4"></div>
    </div>
    <div class="col-span-2">

        <button id="copyMjButton" title="Ctrl + shift + c" class="btn btn-primary h-fit w-fit">
            <i class="text-8xl m-2 fas fa-copy"></i>
        </button>
    </div>
</div>
<div class="m-3">
    <div class="font-extrabold text-8xl bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">
        <h1 id="title" class="text-4xl box-content">Prompt Jounrey</h1>
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
    <div class="grid grid-cols-10 gap-2">
        <div id="text-field" class="p-2 col-span-7 bg-gradient-to-r from-indigo-500 bg-amber-300 overflow-auto">
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
                                        <textarea name="text" id="prompt-text"
                                                  onInput="this.parentNode.dataset.replicatedValue = this.value"
                                                  class="prompt-text-class mt-0" type="text"
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
                                <button id="add-to-suffix-list" class="btn btn-primary">
                                    Add as Suffix
                                </button>
                                <button id="clear" class="btn btn-primary">
                                    Clear
                                </button>
                                <button id="show-history" class="btn btn-primary">
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
                <div class="card-body p-0">
                    <div class="grid grid-cols-4 gap-2 m-2">
                        <div id="aspect-wrapper" data-color="green" class="bg-green-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-400" for="aspect">--aspect</label>
                                <div class="col-span-8">
                                    <select id="aspect" class="parameter-class w-full"></select>
                                </div>
                            </div>
                        </div>
                        <div id="chaos-wrapper" data-color="green" class="bg-green-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-400" for="chaos">--chaos</label>
                                <div class="col-span-8">
                                    <input type="text" id="chaos" class="parameter-class">
                                </div>
                            </div>
                        </div>
                        <div id="quality-wrapper" data-color="green" class="bg-green-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-400" for="aspect">--quality</label>
                                <div class="col-span-8">
                                    <select id="quality" class="parameter-class w-full"></select>
                                </div>
                            </div>
                        </div>
                        <div id="no-wrapper" data-color="green" class="bg-green-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-400" for="no">--no</label>
                                <div class="col-span-8">
                                    <input type="text" id="no" class="parameter-class">
                                </div>
                            </div>
                        </div>
                        <div id="seed-wrapper" data-color="green" class="bg-green-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-400" for="seed">--seed</label>
                                <div class="col-span-8">
                                    <input type="text" id="seed" class="parameter-class">
                                </div>
                            </div>
                        </div>
                        <div id="stop-wrapper" data-color="green" class="bg-green-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-400" for="stop">--stop</label>
                                <div class="col-span-8">
                                    <input type="text" id="stop" class="parameter-class">
                                </div>
                            </div>
                        </div>
                        <div id="style-wrapper" data-color="green" class="bg-green-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-400" for="style">--style</label>
                                <div class="col-span-8">
                                    <select id="style" class="parameter-class w-full"></select>
                                </div>
                            </div>
                        </div>
                        <div id="version-wrapper" data-color="green" class="bg-green-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-400" for="version">--version</label>
                                <div class="col-span-8">
                                    <select id="version" class="parameter-class w-full"></select>
                                </div>
                            </div>
                        </div>
                        <div id="stylize-wrapper" data-color="green" class="bg-green-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-400" for="stylize">--stylize</label>
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
                    <div class="grid grid-cols-4 gap-2 m-2 pb-2 px-2">
                        <div id="niji-wrapper" data-color="sky" class="bg-sky-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-400" for="niji">--niji</label>
                                <div class="col-span-8">
                                    <input type="checkbox" id="niji" class="parameter-class">
                                </div>
                            </div>
                        </div>
                        <div id="hd-wrapper" data-color="sky" class="bg-sky-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-400" for="hd">--hd</label>
                                <div class="col-span-8">
                                    <input type="checkbox" id="hd" class="parameter-class">
                                </div>
                            </div>
                        </div>
                        <div id="test-wrapper" data-color="sky" class="bg-sky-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-400" for="test">--test</label>
                                <div class="col-span-8">
                                    <input type="checkbox" id="test" class="parameter-class">
                                </div>
                            </div>
                        </div>
                        <div id="testp-wrapper" data-color="sky" class="bg-sky-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-400" for="testp">--testp</label>
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
                    <div class="grid grid-cols-4 gap-2 m-2 pb-2 px-2">
                        <div id="uplight-wrapper" data-color="pink" class="bg-pink-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-400" for="uplight">--uplight</label>
                                <div class="col-span-8">
                                    <input type="checkbox" id="uplight" class="parameter-class">
                                </div>
                            </div>
                        </div>
                        <div id="upbeta-wrapper" data-color="pink" class="bg-pink-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-400" for="upbeta">--upbeta</label>
                                <div class="col-span-8">
                                    <input type="checkbox" id="upbeta" class="parameter-class">
                                </div>
                            </div>
                        </div>
                        <div id="upanime-wrapper" data-color="pink" class="bg-pink-300 parameter-container">
                            <div class="grid grid-cols-12 flex items-center">
                                <label class="col-span-4 text-gray-400" for="upanime">--upanime</label>
                                <div class="col-span-8">
                                    <input type="checkbox" id="upanime" class="parameter-class">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-2 col-span-3 bg-green-300">
            <div id="suffix" class="card">
                <div class="card-header">
                    <h2>suffix</h2>
                </div>
                <div class="card-body">
                    <div id="input-suffix-fields">
                        <div class="flex mt-2">
                            <div class="flex-none px-3">
                                <input type="checkbox" name="suffixAdd[]" class="suffix-add">
                            </div>
                            <div class="grow">
                                <input type="text" name="suffix[]" class="suffix-input disabled:text-gray-400">
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
                            <input type="checkbox" name="suffixAdd[]" class="images-add">
                        </div>
                        <div class="grow">
                            <input type="text" name="suffix[]" class="images-input disabled:text-gray-400">
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
                            suffix copid to clipboard
                        </div>
                    </div>
                    <div class="flex content-end flex-row-reverse">
                        <button class="add-images btn btn-primary">Add image link</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Shortcut List
            </div>
            <div class="card-body grid grid-cols-2 gap-x-3 gap-y-2">
                <div class="col-span-full border-b border-gray-400">
                    Main Shortcut
                </div>
                <div class="col-span-1 flex flex-row items-center justify-between">
                    <span class="text-gray-500 font-medium text-xs mr-4">Ctrl + Space</span>
                    <span class="text-gray-900 font-medium text-xs">focus prompt</span>
                </div>
                <div class="col-span-1 flex flex-row items-center justify-between">
                    <span class="text-gray-500 font-medium text-xs mr-4">Ctrl + shift + c:</span>
                    <span class="text-gray-900 font-medium text-xs">copy Mj Prompt</span>
                </div>
                <div class="col-span-full border-b border-gray-400">
                    Action Shortcut
                </div>
                <div class="col-span-1 flex flex-row items-center justify-between">
                    <span class="text-gray-500 font-medium text-xs mr-4">Ctrl + Alt + Shift + s:</span>
                    <span class="text-gray-900 font-medium text-xs">add as Suffix</span>
                </div>
                <div class="col-span-1 flex flex-row items-center justify-between">
                    <span class="text-gray-500 font-medium text-xs mr-4">Ctrl + Alt + Shift + F4:</span>
                    <span class="text-gray-900 font-medium text-xs">Clear all</span>
                </div>
                <div class="col-span-1 flex flex-row items-center justify-between">
                    <span class="text-gray-500 font-medium text-xs mr-4">Ctrl + Alt + Shift + h:</span>
                    <span class="text-gray-900 font-medium text-xs">history</span>
                </div>
                <div class="col-span-full border-b border-gray-400">
                    Basic Param shortcuts
                </div>
                <div class="col-span-1 flex flex-row items-center justify-between">
                    <span class="text-gray-500 font-medium text-xs mr-4">Ctrl + Alt + a:</span>
                    <span class="text-gray-900 font-medium text-xs">aspect </span>
                </div>
                <div class="col-span-1 flex flex-row items-center justify-between">
                    <span class="text-gray-500 font-medium text-xs mr-4">Ctrl + Alt + c:</span>
                    <span class="text-gray-900 font-medium text-xs">chaos</span>
                </div>
                <div class="col-span-1 flex flex-row items-center justify-between">
                    <span class="text-gray-500 font-medium text-xs mr-4">Ctrl + Alt + q:</span>
                    <span class="text-gray-900 font-medium text-xs">quality</span>
                </div>
                <div class="col-span-1 flex flex-row items-center justify-between">
                    <span class="text-gray-500 font-medium text-xs mr-4">Ctrl + Alt + n:</span>
                    <span class="text-gray-900 font-medium text-xs">no</span>
                </div>
                <div class="col-span-1 flex flex-row items-center justify-between">
                    <span class="text-gray-500 font-medium text-xs mr-4">Ctrl + Alt + e:</span>
                    <span class="text-gray-900 font-medium text-xs">seed</span>
                </div>
                <div class="col-span-1 flex flex-row items-center justify-between">
                    <span class="text-gray-500 font-medium text-xs mr-4">Ctrl + Alt + t:</span>
                    <span class="text-gray-900 font-medium text-xs">stop</span>
                </div>
                <div class="col-span-1 flex flex-row items-center justify-between">
                    <span class="text-gray-500 font-medium text-xs mr-4">Ctrl + Alt + y:</span>
                    <span class="text-gray-900 font-medium text-xs">style</span>
                </div>
                <div class="col-span-1 flex flex-row items-center justify-between">
                    <span class="text-gray-500 font-medium text-xs mr-4">Ctrl + Alt + v:</span>
                    <span class="text-gray-900 font-medium text-xs">version</span>
                </div>
                <div class="col-span-1 flex flex-row items-center justify-between">
                    <span class="text-gray-500 font-medium text-xs mr-4">Ctrl + Alt + s:</span>
                    <span class="text-gray-900 font-medium text-xs">stylize</span>
                </div>
                <div class="col-span-full border-b border-gray-400">
                    Model version Param shortcuts
                </div>
                <div class="col-span-1 flex flex-row items-center justify-between">
                    <span class="text-gray-500 font-medium text-xs mr-4">Alt + n:</span>
                    <span class="text-gray-900 font-medium text-xs">niji</span>
                </div>
                <div class="col-span-1 flex flex-row items-center justify-between">
                    <span class="text-gray-500 font-medium text-xs mr-4">Alt + h:</span>
                    <span class="text-gray-900 font-medium text-xs">hd</span>
                </div>
                <div class="col-span-1 flex flex-row items-center justify-between">
                    <span class="text-gray-500 font-medium text-xs mr-4">Alt + t:</span>
                    <span class="text-gray-900 font-medium text-xs">test</span>
                </div>
                <div class="col-span-1 flex flex-row items-center justify-between">
                    <span class="text-gray-500 font-medium text-xs mr-4">Alt + p:</span>
                    <span class="text-gray-900 font-medium text-xs">testp</span>
                </div>
                <div class="col-span-full border-b border-gray-400">
                    Upscaler Param shortcuts
                </div>
                <div class="col-span-1 flex flex-row items-center justify-between">
                    <span class="text-gray-500 font-medium text-xs mr-4">Alt + l:</span>
                    <span class="text-gray-900 font-medium text-xs">uplight</span>
                </div>
                <div class="col-span-1 flex flex-row items-center justify-between">
                    <span class="text-gray-500 font-medium text-xs mr-4">Alt + b:</span>
                    <span class="text-gray-900 font-medium text-xs">upbeta</span>
                </div>
                <div class="col-span-1 flex flex-row items-center justify-between">
                    <span class="text-gray-500 font-medium text-xs mr-4"> Alt + a:</span>
                    <span class="text-gray-900 font-medium text-xs">upanime</span>
                </div>
            </div>

            <div class="card-footer">
                <div class="text-[10px]">
                    *NOTE: Depending on the browser or operating system you are using, some of these shortcuts might not function as expected.
                </div>
            </div>
        </div>
    </div>
</div>


<div id="overlayContainer"></div>

<div id="overlayHistory"></div>
@endsection

@section('scripts')
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
            setPromptWithImagesText();
            setPromptWithSuffixText();

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

