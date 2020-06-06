<div class="mb-6 last-child:mb-0 {{ $class ?? '' }}">
    <label for="{{ $name }}" class="block text-lg font-bold mb-1">
        {{ $label }}
    </label>
    <input
        id="{{ $name }}"
        type="{{ $type ?? 'text' }}"
        class="block w-full p-4 bg-gray-200 rounded @error($name) bg-red-100 @enderror"
        name="{{ $name }}"
        value="{{ $value ?? old($name) }}"
        {!! isset($placeholder) ? "placeholder=\"{$placeholder}\"" : '' !!}
        {!! isset($min) ? "min=\"{$min}\"" : '' !!}
        {!! isset($max) ? "max=\"{$max}\"" : '' !!}
        {!! isset($maxLength) ? "maxlength=\"{$maxLength}\"" : '' !!}
        {!! isset($autoComplete) ? "auto-complete=\"{$autoComplete}\"" : '' !!}
        {!! isset($required) && $required ? 'required' : '' !!}
        {!! isset($autofocus) && $autofocus ? 'autofocus' : '' !!}
    >
    @error($name)
        <div class="mt-2" role="alert">{{ $message }}</div>
    @enderror
</div>
