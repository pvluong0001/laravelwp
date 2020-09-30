@if(flash()->message)
    <div class="title is-4 px-3 py-3 {{ flash()->class }}">
        <i class="fas fa-info-circle"></i> {{ flash()->message }}
    </div>
@endif
