<div class="mb-6 last-child:mb-0 {{ $class ?? '' }}">
    <label for="{{ $name }}" class="block text-lg font-bold mb-1">
        {{ $label }}
    </label>
    <textarea
        id="{{ $name }}"
        class="block w-full p-4 bg-gray-200 rounded"
        name="{{ $name }}"
        placeholder="{{  $placeholder }}"
        rows="{{ $rows ?? 5 }}"
        maxlength="{{ $maxLength ?? '' }}"
        {{ isset($required) && $required ? 'required' : '' }}
    >{{  $value ?? old($name) }}</textarea>
</div>
