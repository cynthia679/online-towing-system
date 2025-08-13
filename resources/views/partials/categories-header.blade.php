<ul class="list-inline">
    @forelse($categories as $category)
        <li class="list-inline-item badge bg-secondary p-2 m-1">
            <a href="{{ route('categories.show', $category->id) }}" class="text-white text-decoration-none">
                {{ $category->name }}
            </a>
        </li>
    @empty
        <li>No categories found.</li>
    @endforelse

    {{-- Add All Categories link --}}
    <li class="list-inline-item badge bg-primary p-2 m-1">
        <a href="{{ route('categories.index') }}" class="text-white text-decoration-none">
            All Categories
        </a>
    </li>
</ul>
