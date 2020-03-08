@if ($article->categories && $article->categories->count())
    <ul class="mb-4 text-xs uppercase tracking-widest sm:text-sm">
        @foreach ($article->categories as $category)
            <li class="leading-none">
                <a href="{{ $category->showPath() }}"
                    class="block text-gray-600 hover:text-gray-900"
                >
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>
@endif
