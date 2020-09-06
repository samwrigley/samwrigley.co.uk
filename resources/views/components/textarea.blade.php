<div {{ $attributes->only('class')->merge(['class' => 'mb-6 last-child:mb-0']) }}>
    <label for="{{ $name }}" class="block text-lg font-bold mb-1">
        {{ $label }}
    </label>
    <textarea
        class="block w-full p-4 bg-gray-200 rounded @error($name, $errorBag) bg-red-100 @enderror"
        {{ $attributes->except('class')->merge([
            'id' => $name,
            'name' => $name,
            'rows' => '5',
        ]) }}
    >{{  $value ?? old($name) }}</textarea>
    @error($name, $errorBag)
        <x-error message="{{ $message }}" />
    @enderror
</div>
