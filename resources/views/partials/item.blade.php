<li class="post" data-id="{{$post->id}}">
    <label>
        {{-- Checkbox reflects whether the item is done --}}
        

        {{-- Item description --}}
        <span>{{ $item->description }}</span>

        {{-- Delete button (handled via JS) --}}
        <a href="#" class="delete">&#10761;</a>
    </label>
</li>