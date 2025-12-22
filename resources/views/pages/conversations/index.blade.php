@extends('layouts.app')

@section('title', 'Conversation')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/conversation.css') }}">
@endpush

@section('content')
<div class="container py-5">

    <div class="row">
        <div class="col-md-12">

            <div class="card" style="border-radius: 15px;">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">
                            @include('pages.conversations.partials.sidebar')
                        </div>

                        <!-- Coluna direita (placeholder) -->
                        <div class="col-md-6 col-lg-7 col-xl-8 d-flex align-items-center justify-content-center">
                            <div class="text-center text-muted">
                                <h5 class="mb-2">Select a conversation</h5>
                                <p>Pick a chat from the column.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection