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

        .bookstore-pagination .page-item {
            margin: 0;
        }

        .bookstore-pagination .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
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
            box-shadow: none;
            transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
        }

        .bookstore-pagination .page-link:hover {
            background: #edf4ff;
            border-color: #bfd5f5;
            color: #102f5b;
        }

        .bookstore-pagination .page-item.active .page-link {
            background: #0a1f44;
            border-color: #0a1f44;
            color: #ffffff;
        }

        .bookstore-pagination .page-item.disabled .page-link {
            opacity: 0.52;
            cursor: not-allowed;
            background: #f7f9fd;
            color: #6e7f9e;
        }

        .bookstore-pagination svg {
            width: 16px;
            height: 16px;
            max-width: 16px;
            max-height: 16px;
        }

        @media (max-width: 576px) {
            .bookstore-pagination {
                gap: 6px;
                flex-wrap: wrap;
                justify-content: center;
            }

            .bookstore-pagination .page-link {
                min-width: 32px;
                height: 32px;
                padding: 5px 10px;
                font-size: 13px;
            }
        }
    </style>

    <nav role="navigation" aria-label="Pagination Navigation" class="bookstore-pagination-wrap">
        <ul class="bookstore-pagination">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="Previous page">
                    <span class="page-link" aria-hidden="true">&larr;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous page">&larr;</a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next page">&rarr;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="Next page">
                    <span class="page-link" aria-hidden="true">&rarr;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
