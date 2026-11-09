@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="Pagination">

        @if ($paginator->onFirstPage())
            <button type="button" disabled>←</button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}">←</a>
        @endif

        @php
            $start = max(1, $paginator->currentPage() - 2);
            $end = min($paginator->lastPage(), $paginator->currentPage() + 2);
        @endphp

        @if ($start > 1)
            <a href="{{ $paginator->url(1) }}">1</a>
            @if ($start > 2)
                <span class="pagination-ellipsis">…</span>
            @endif
        @endif

        @for ($page = $start; $page <= $end; $page++)
            @if ($page == $paginator->currentPage())
                <button type="button" class="page-active">{{ $page }}</button>
            @else
                <a href="{{ $paginator->url($page) }}">{{ $page }}</a>
            @endif
        @endfor

        @if ($end < $paginator->lastPage())
            @if ($end < $paginator->lastPage() - 1)
                <span class="pagination-ellipsis">…</span>
            @endif
            <a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">→</a>
        @else
            <button type="button" disabled>→</button>
        @endif

    </nav>
@endif
