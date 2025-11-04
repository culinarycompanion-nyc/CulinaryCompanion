@props(['value', 'label', 'selected' => []])

@php
    $isSelected = in_array($value, $selected);
@endphp

<label class="cursor-pointer">
    <input type="checkbox" name="checkboxes[]" value="{{ $value }}" class="hidden peer" {{ $isSelected ? 'checked' : '' }}>
    <div
        class="peer-checked:bg-green-600 peer-checked:text-white text-gray-700 border border-gray-300 rounded-lg px-1 py-2 text-center text-xs md:text-sm hover:bg-green-100 transition select-none">
        {{ $label }}
    </div>
</label>