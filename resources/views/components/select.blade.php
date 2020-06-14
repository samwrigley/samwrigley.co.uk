@if($items->count())
    <div {{ $attributes->only('class')->merge(['class' => 'mb-6 last-child:mb-0']) }}>
        <label for="{{ $name }}" class="block text-lg font-bold mb-1">
            {{ $label }}
        </label>
        <select
            class="block w-full p-4 bg-gray-200 rounded @error($name) bg-red-100 @enderror"
            {{ $attributes->except('class')->merge([
                'id' => $name,
                'name' => $name,
            ]) }}
        >
            {{ $slot }}
        </select>
        @error($name)
            <div class="mt-2" role="alert">{{ $message }}</div>
        @enderror
    </div>
@endif
