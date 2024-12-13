@extends('words.layouts.master')
@section('head-tag')
    <title>{{ __('Random') }}</title>
@endsection
@section('inner_content')
    <div class="container mt-5 text-center">
        <div class="row justify-content-center">
            <div class="col-auto">
                <button class="btn btn-primary" data-url="{{ route('random-words') }}"
                    id="randomBtn">{{ __('Refresh') }}</button>
                <h4 id="index" class="mt-2 mb-4" style="direction: ltr;"> 0 / 20</h4>
            </div>
        </div>

        <div class="row justify-content-center gap-3 mb-5" id="card-wrapper">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <h3 class="card-title mb-2" id="title"></h3>
                        <audio src="" id="audio"></audio>
                        <a id="translate" class="card-text d-block mb-2 fw-bold text-secondary">{{ __('View') }}</a>
                        <a id="example" class="card-text d-block mb-2 fw-bold text-secondary">{{ __('Example') }}</a>
                        <a id="value" dir="ltr">{{ __('Amount') }}</a>
                        <div class="d-flex justify-content-around p-3 button_links">
                            <a href="#" data-url="{{ route('known') }}" id="known"
                                class="btn btn-primary fw-bold action ">{{ __('Known') }}</a>
                            <a href="#" data-url="{{ route('learned') }}" id="learn"
                                class="btn btn-success fw-bold action">{{ __('Learned') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
