@if ($article->categories && $article->categories->count())
    <ul class="flex flex-col sm:flex-row">
        @foreach ($article->categories as $category)
            <li class="mb-1 last:mb-0 sm:mr-3 sm:mb-0 sm:last:mr-0">
                <a href="{{ $category->showPath() }}"
                    class="block text-gray-600 hover:text-gray-900"
                >
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>
@endif
