<article class="card" data-id="{{ $jobpost->id }}">
    <header>
        <h2>
            {{-- Link to the jobpost detail page --}}
            <a href="{{ route('jobposts.show', $jobpost) }}">
                {{ $jobpost->title }}
            </a>
        </h2>
        {{-- Delete button (JS handles behavior) --}}
        <a href="#" class="delete">&#10761;</a>
    </header>

    <div class="meta">
        @if(!empty($jobpost->location))
            <span class="location">{{ $jobpost->location }}</span>
        @endif
        @if(!empty($jobpost->salary))
            <span class="salary">{{ number_format($jobpost->salary, 2) }}</span>
        @endif
    </div>

    <div class="description">
        {{ $jobpost->description ?? '' }}
    </div>

    <ul>
        {{-- Render each item belonging to this jobpost (if any) --}}
        @if(method_exists($jobpost, 'items'))
            @each('partials.item', $jobpost->items, 'item')
        @endif
    </ul>

    {{-- Inline form to create a new item for this jobpost --}}
    <form class="new_item">
        <input type="text" name="description" placeholder="new item">
    </form>
</article>
