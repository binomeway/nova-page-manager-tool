@php($images = $block->getMedia('images'))

@foreach($images as $image)
    <figure>
        <img src="{{ $image->getUrl() }}" alt="{{ $image->getCustomProperty('alt') }}" style="width:100%">
        @if($image->hasCustomProperty('description'))
            <figcaption>{{ $image->getCustomProperty('description')  }}</figcaption>
        @endif
    </figure>
@endforeach
