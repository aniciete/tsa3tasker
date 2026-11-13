@props(['title', 'copy', 'linkUrl' => null, 'linkLabel' => null])

<div class="empty-state">
    <p class="empty-title">{{ $title }}</p>
    <p class="empty-copy">{{ $copy }}</p>
    @if ($linkUrl && $linkLabel)
        <a href="{{ $linkUrl }}" class="text-link">{{ $linkLabel }}</a>
    @endif
</div>
