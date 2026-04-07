@if ($paginator->hasPages())
    <style>
        .bookstore-pagination-wrap {
            display: flex;
            justify-content: center;
            width: 100%;
            margin-top: 0.9rem;
        }

        .bookstore-pagination {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            max-width: fit-content;
            margin: 0 auto;
            padding: 0;
            list-style: none;
        }

        .bookstore-pagination .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 72px;
            height: 34px;
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid #d6e3f6;
            background: #ffffff;
            color: #173a6d;
            text-decoration: none;
            font-size: 14px;
            line-height: 1;
            font-weight: 600;
            transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
        }

        .bookstore-pagination .page-link:hover {
            background: #edf4ff;
            border-color: #bfd5f5;
            color: #102f5b;
        }

        .bookstore-pagination .disabled .page-link {
            opacity: 0.52;
            cursor: not-allowed;
            background: #f7f9fd;
            color: #6e7f9e;
        }
    </style>

    <nav role="navigation" aria-label="Pagination Navigation" class="bookstore-pagination-wrap">
        <ul class="bookstore-pagination">
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true"><span class="page-link">Prev</span></li>
            @else
                <li><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Prev</a></li>
            @endif

            @if ($paginator->hasMorePages())
                <li><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a></li>
            @else
                <li class="disabled" aria-disabled="true"><span class="page-link">Next</span></li>
            @endif
        </ul>
    </nav>
@endif
