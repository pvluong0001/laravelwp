<select name="{{ $name ?? '' }}" class="select is-fullwidth {{ $class ?? '' }}" {{ $attribute ?? '' }}>
    @foreach($data as $type => $text)
    <option value="{{ $type }}">{{ $text }}</option>
    @endforeach
</select>
