@extends('layouts.app')

@section('title', 'Conversation')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/conversation.css') }}">
@endpush

@section('content')
<div class="container py-5 conversation-page">

    <div class="row">
        <div class="col-md-12">

            <div class="card" style="border-radius: 15px;">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">
                            @include('pages.conversations.partials.sidebar', [
                                'activeConversation' => $conversation ?? null
                            ])
                        </div>

                        {{-- COLUNA DIREITA: chat --}}
                        <div class="col-md-6 col-lg-7 col-xl-8">

                            {{-- HEADER (fixo no topo) --}}
                            <div class="border-bottom pb-2 mb-2 pt-3 pe-3">
                                <h4>
                                    {{ $conversation->displayConversationName(Auth::user()) ?? 'Conversation' }}
                                </h4>
                            </div>

                            <div id="chat-scroll" class="pe-3 overflow-y-auto"
                                style="position: relative; height: 400px">

                                {{-- MENSAGENS --}}
                                <div id="messages"
                                    class="flex-grow-1 overflow-y-auto mb-3 pe-2">

                                    @forelse ($messages as $message)
                                    @php
                                    $mine = auth()->id() === $message->sender_id;
                                    @endphp

                                    @if($mine)
                                    <div class="d-flex flex-row justify-content-end mb-3">
                                        <div>
                                            <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">{{ $message->body }}</p>
                                            <p class="small me-3 mb-3 rounded-3 text-muted">{{ $message->created_at->format('H:i | M d') }}</p>
                                        </div>
                                        <img src="{{ Auth::user()->avatarUrl() }}"
                                            alt="avatar 1" class="avatar">
                                    </div>
                                    @else
                                    <div class="d-flex flex-row justify-content-start mb-3">
                                        <img src="{{ $message->conversation->otherUserFor(Auth::user())->avatarUrl() }}"
                                            alt="avatar 1" class="avatar">
                                        <div>
                                            <p class="small p-2 ms-3 mb-1 rounded-3 bg-light">{{ $message->body }}</p>
                                            <p class="small ms-3 mb-3 rounded-3 text-muted">{{ $message->created_at->format('H:i | M d') }}</p>
                                        </div>
                                    </div>
                                    @endif

                                    @empty
                                    <p class="text-muted">No messages yet.</p>
                                    @endforelse

                                </div>

                            </div>
                            
                            <script>
                                // Scroll to bottom immediately to prevent visible jump
                                (function() {
                                    const scroller = document.getElementById('chat-scroll');
                                    if (scroller) {
                                        scroller.scrollTop = scroller.scrollHeight;
                                    }
                                })();
                            </script>
                            {{-- FORM ENVIAR --}}

                            <div class="text-muted d-flex justify-content-start align-items-center pe-3 pt-3 mt-2">
                                <form method="POST"
                                    action="{{ route('messages.store', $conversation) }}" class="d-flex gap-2 w-100">
                                    @csrf
                                    <input type="text"
                                        name="body"
                                        class="form-control form-control-lg"
                                        placeholder="Type a message..."
                                        required>
                                    <button type="submit" class="btn btn-link ms-3 p-0">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
    @push('scripts')
    <script>
        window.conversationId = {{ $conversation->id }};
        window.authUserId = {{ auth()->id() }};
        window.authAvatarUrl = @json(Auth::user()->avatarUrl());
        window.otherAvatarUrl = @json($conversation->otherUserFor(Auth::user())->avatarUrl());
    </script>
    @endpush
    @endsection