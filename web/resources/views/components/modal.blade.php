<button class="button is-primary is-small modal-button" data-target="modal-{{ $uuid }}" aria-haspopup="true">Launch card modal</button>

<div class="modal" data-uuid="modal-{{ $uuid }}">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">{{ $title }}</p>
            <button class="delete modal-button" data-target="modal-{{ $uuid }}" aria-label="close"></button>
        </header>
        <form action="{{ $action ?? '' }}" method="POST">
            @csrf
            @method($actionMethod ?? 'POST')
            <section class="modal-card-body">
                {{ $content ?? '' }}
            </section>
            <footer class="modal-card-foot">
                @isset($footer)
                    {{ $footer }}
                @else
                    <div class="has-text-right">
                        <button class="button is-success" type="{{ empty($action) ? 'button' : 'submit' }}">Save changes</button>
                        <button class="button modal-button" data-target="modal-{{ $uuid }}">Cancel</button>
                    </div>
                @endisset
            </footer>
        </form>
    </div>
</div>
