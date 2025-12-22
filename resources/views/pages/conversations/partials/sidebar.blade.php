<div class="p-3">

    {{-- COLUNA ESQUERDA: lista de conversas --}}
    <h6 class="mb-3">Conversations</h6>

    <div class="overflow-y-auto" style="position: relative; height: 400px">
        <ul class="list-unstyled mb-0">
            @php
            $activeConversation = $activeConversation ?? null;
            $activeId = $activeConversation?->id;
            @endphp

            @forelse ($conversations as $c)

            @php
            $otherUser = $c->otherUserFor(Auth::user());
            $isActive = $activeId === $c->id;
            @endphp
            <li class="p-2 my-2 border-bottom {{ $isActive ? 'active' : '' }}">
                <a href="{{ route('conversations.show', $c) }}" class="d-flex justify-content-between text-decoration-none">
                    <div class="d-flex flex-row">
                        <div>
                            <img
                                src="{{ $otherUser->avatarUrl() }}"
                                alt="avatar" class="avatar avatar-lg align-self-center me-3" width="60">
                        </div>
                        <div class="pt-1">
                            <p class="fw-bold mb-0">{{ $c->displayConversationName(Auth::user()) ?? 'Conversation' }}</p>
                            <p class="small text-muted">{{ $c->latestMessagePreview() ?? 'No messages'}}</p>
                        </div>
                    </div>
                    <div class="pt-1">
                        <p class="small text-muted mb-1">{{ $c->updated_at->diffForHumans()}}</p>
                    </div>
                </a>
            </li>
            @empty
            <li class="text-muted">No conversations</li>
            @endforelse
        </ul>
    </div>
</div>