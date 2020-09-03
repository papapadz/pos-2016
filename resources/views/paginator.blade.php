@if ($paginator->lastPage() > 1)
    <?php
        $start = $paginator->currentPage() - 3; // show 3 pagination links before current
        $end = $paginator->currentPage() + 3; // show 3 pagination links after current
        if($start < 1) $start = 1; // reset start to 1
        if($end >= $paginator->lastPage() ) $end = $paginator->lastPage(); // reset end to last page
    ?>

    <ul class="uk-pagination">
        <li class="{{ ($paginator->currentPage() == 1) ? 'uk-disabled' : '' }}">
            @if($paginator->currentPage() == 1)
                <span><i class="uk-icon-angle-double-left"></i></span>
            @else
                <a href="{{ $paginator->url(1) }}"><i class="uk-icon-angle-double-left"></i></a>
            @endif
        </li>
        @if($start > 1)
            <li>
                <span><a href="{{ $paginator->url(1) }}">{{1}}</a></span>
            </li>
            <li class="uk-disabled"><a href="#">...</a></li>
        @endif

        @for ($i = $start; $i <= $end; $i++)
            <li class="{{ ($paginator->currentPage() == $i) ? 'uk-active' : '' }}">
                @if($paginator->currentPage() == $i)
                    <span>{{$i}}</span>
                @else
                    <a href="{{ $paginator->url($i) }}">{{$i}}</a>
                @endif
            </li>
        @endfor

        @if($end < $paginator->lastPage())
            <li class="uk-disabled"><a href="#">...</a></li>
            <li>
                <span><a href="{{ $paginator->url($paginator->lastPage()) }}">{{$paginator->lastPage()}}</a></span>
            </li>
        @endif
        <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? 'uk-disabled' : '' }}">
            @if($paginator->currentPage() == $paginator->lastPage())
                <span><i class="uk-icon-angle-double-right"></i></span>
            @else
                <a href="{{ $paginator->url($paginator->currentPage()+1) }}"><i class="uk-icon-angle-double-right"></i></a>
            @endif
        </li>
    </ul>

@endif