<div {{ $attributes->only('class')->merge(['class' => 'mb-6 last-child:mb-0']) }}>
    <label>
        <input
            class="mr-1"
            type="checkbox"
            name="{{ $label }}"
            {{ old($label) ? 'checked' : '' }}
        >
        <span>{{ $label }}</span>
    </label>
</div>
