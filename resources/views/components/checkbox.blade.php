@vite(['resources/css/main.css'])

<div class="checkbox-wrapper z-10 col-span-2">
    <label class="checkbox-wrapper">
        <input type="checkbox" class="checkbox-input" name="checkboxes[]" value="{{ $value }}" {{ in_array($value, $selected ?? []) ? 'checked' : '' }} />
        <span class="checkbox-tile">
            <span class="checkbox-icon">
            </span>
            <span class="checkbox-label">{{ $label }}</span>
        </span>
    </label>
</div>