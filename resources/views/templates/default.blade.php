<x-app-layout>
    <x-slot name="header">
        {{ $page->title }}
    </x-slot>

    <div class="py-12 max-w-2xl mx-auto">
        <article class="prose prose-lg">
            @foreach($page->blocks as $block)
                @include($block->component())
            @endforeach
        </article>
    </div>
</x-app-layout>
