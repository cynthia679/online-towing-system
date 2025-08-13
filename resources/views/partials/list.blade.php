@if(count($categories) > 0)
    <ul class="list-group">
        @foreach($categories as $category)
            <li class="list-group-item">{{ $category->name }}</li>
        @endforeach
    </ul>
@else
    <p>No categories found.</p>
@endif
