<div class="col-xxl-12 ">
    <!-- pagination part start  -->

    <ul class="pagination pagination_two">
        @if ($paginator->onFirstPage())
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}">
                    <span>
                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 1L1 7L7 13" stroke-width="2" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>

                    </span>
                </a>
            </li>
        @endif
        @foreach ($elements as $element)
            @if (is_array($element))
                @if (count($element) < 2)
                @else
                    @foreach ($element as $key => $el)
                        @if ($key == $paginator->currentPage())
                            <li><a class="active" href="javascript::void()">{{ $key }}</a></li>
                        @else
                            <li><a href="{{ $el }}">{{ $key }}</a></li>
                        @endif
                    @endforeach
                @endif
            @else
                <li><a href="javascript::void()">...</a></li>
            @endif

        @endforeach
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}">
                    <span>
                        <svg width="9" height="14" viewBox="0 0 9 14" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.375 1L7.625 7L1.375 13" stroke-width="2" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                    </span>
                </a>
            </li>
        @endif
    </ul>

    <!-- pagination part end  -->
</div>
