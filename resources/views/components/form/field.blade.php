@props([
    'label' => false,
    'name',
    'type' => 'text',
    'rows' => 3,
    'value' => ''
])
<div class="space-y-2">
    @if($label)
        <label for="{{ $name }}" class="label">{{ $label }}</label>
    @endif
    @if($type === 'textarea')
        <textarea
            name="{{ $name }}"
            id="{{ $name }}"
            class="textarea"
            {{ $attributes }}
            rows="{{ $rows }}"
        >
            {{ old( $name, $value) }}
        </textarea>
    @else
        <input
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            class="input"
            autocomplete="{{ $name }}"
            autofocus
            {{ $attributes }}
        >
    @endif

    <x-form.error name="{{ $name }}" />
</div>
