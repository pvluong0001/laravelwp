<div class="field">
    <label class="label is-capitalized">{{ $field['label'] ?? $field['name'] }}</label>
    <div class="control">
        <input type="text" name="{{ $field['name'] }}" value="{{ old($field['name']) }}" class="input">
    </div>
</div>