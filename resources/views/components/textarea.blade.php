<div {{ $attributes->only('class')->merge(['class' => 'mb-6 last-child:mb-0']) }}>
    <label for="{{ $name }}" class="block text-lg font-bold mb-1">
        {{ $label }}
    </label>
    <textarea
        class="block w-full p-4 bg-gray-200 rounded"
        {{ $attributes->except('class')->merge([
            'id' => $name,
            'name' => $name,
            'rows' => '5',
        ]) }}
    >{{  $value ?? old($name) }}</textarea>
    @error($name)
        <div class="mt-2" role="alert">{{ $message }}</div>
    @enderror
</div>
