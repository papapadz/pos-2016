@extends('secretary')

@section('content')

    <div style="background-color: #e2e2e2; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">

            <div class="uk-grid">
                <div class="uk-width-1-1">

                    <div style="margin-top:15px;">

                        <h2>Category List</h2>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right" style="background-color: #e5e4e4;">
                            {!! Form::open(['method'=>'get', 'class'=>'uk-form']) !!}
                            {!! Form::text('skey', $skey) !!}
                            {!! Form::button('Filter', ['type'=>'submit', 'class'=>'uk-button uk-button-success']) !!}

                            <a href="{{ route('secretaryCategoryCreate') }}" class="uk-button uk-button-primary"><i class="uk-icon-plus"></i> Create Category</a>
                        </div>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary">

                            <table class="uk-table uk-table-hover uk-table-striped">
                                <thead>
                                <tr>
                                    <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                                    <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                                    <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                                    <th style="background-color: #464646; color: #fff;" width="400">Category Name</th>
                                    <th style="background-color: #464646; color: #fff;">Description</th>
                                    <th style="background-color: #464646; color: #fff;" width="65">&nbsp;</th>
                                </tr>
                                </thead>

                                @if(count($categories) > 0)
                                    <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>{{ $category->categoryname }}</td>
                                            <td>{{ $category->description }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <td colspan="8"><i>{{ count($categories) }} - Category record found</i></td>
                                    </tr>
                                    </tfoot>
                                @else
                                    <tfoot>
                                    <tr>
                                        <td colspan="8"><i>No records found</i></td>
                                    </tr>
                                    </tfoot>
                                @endif

                            </table>

                            <div>
                                @include('paginator', ['paginator' => $categories])
                            </div>

                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>

@stop

@section('location') Category @stop