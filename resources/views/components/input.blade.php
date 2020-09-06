<div {{ $attributes->only('class')->merge(['class' => 'mb-6 last-child:mb-0']) }}>
    <label for="{{ $name }}" class="block text-lg font-bold mb-1">
        {{ $label }}
    </label>
    <input
        class="block w-full p-4 bg-gray-200 rounded @error($name, $errorBag) bg-red-100 @enderror"
        {{ $attributes->except('class')->merge([
            'id' => $name,
            'name' => $name,
            'type' => 'text',
            'value' => old($name),
        ]) }}
    >
    @error($name, $errorBag)
        <x-error message="{{ $message }}" />
    @enderror
</div>
