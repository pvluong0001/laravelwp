@if(empty($link))
    <button type="{{ $type }}" class="button {{ $class }} {{ $size }}" id="{{ $id ?? strtolower($text) }}">{{ $text }}</button>
@else
    <a href="{{ $link }}" class="button {{ $class }} {{ $size }}" id="{{ $id ?? strtolower($text) }}">{{ $text }}</a>
@endif

