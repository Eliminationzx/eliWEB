@if ($paginator->hasPages())




    <ul class="pagination pull-right">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="footable-page-arrow disabled">
                <a data-page="prev">&laquo;</a>
            </li>
        @else
            <li class="footable-page-arrow">
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="footable-page">
                    <a>{{ $element }}</a>
                </li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="footable-page active">
                        <a >{{ $page }}</a>
                        </li>
                    @else
                        <li class="footable-page">
                        <a href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="footable-page-arrow">
            <a href="{{ $paginator->nextPageUrl() }}" >&raquo;</a>
            </li>
        @else
            <li class="footable-page-arrow disabled">
                <a data-page="first">&raquo;</a>
            </li>
        @endif
    </ul>
@endif
