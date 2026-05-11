@props(['question'])
@php
    $panelId = 'cc-faq-panel-' . str_replace('.', '', uniqid('', true));
@endphp
<article {{ $attributes->class('cc-faq-item') }} data-faq-item>
    <button
        type="button"
        class="cc-faq-item__summary"
        data-faq-trigger
        aria-expanded="false"
        aria-controls="{{ $panelId }}"
    >
        <span class="cc-faq-item__question">{{ $question }}</span>
        <span class="cc-faq-item__icon" aria-hidden="true">+</span>
    </button>
    <div
        id="{{ $panelId }}"
        class="cc-faq-item__panel"
        data-faq-panel
        hidden
    >
        <div class="cc-faq-item__answer">
            {!! $slot !!}
        </div>
    </div>
</article>
