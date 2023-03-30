<?php $isDashboardPage = true; ?>
@extends('layouts.modal')

@section('content')
<div>
    @if (isset($projectId) && $projectId !== null)
    <input type="hidden" value="{{$projectId}}" name="projectId" id="projectId">
    @endif

    <div id="suffix" class="card">
        <div class="card-header">
            <h2>suffix</h2>
        </div>
        <div class="card-body">
            <div id="input-suffix-fields">
                <div class="flex mt-2">
                    <span class="handle my-auto cursor-grab">&#9776;</span>
                    <div class="flex-none px-3">
                        <input type="checkbox" name="suffixAdd-1" id="suffix-add-1" class="suffix-add">
                    </div>
                    <div class="grow">
                        <input type="text" name="suffix-1" id="suffix-input-1"
                               class="suffix-input disabled:text-gray-600">
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
        </div>
    </div>
</div>
@endsection


