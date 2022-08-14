@extends('admin')

@section('content')

    <div style="background-color: #e2e2e2; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">

            <div class="uk-grid">
                <div class="uk-width-1-1">

                    <div style="margin-top:20px;">

                        <h2>Supplier List</h2>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right" style="background-color: #e5e4e4;">
                            {!! Form::open(['method'=>'get', 'class'=>'uk-form']) !!}
                            {!! Form::text('skey', $skey) !!}
                            {!! Form::button('Filter', ['type'=>'submit', 'class'=>'uk-button uk-button-success']) !!}

                            <a href="{{ route('supplierCreate') }}" class="uk-button uk-button-primary"><i class="uk-icon-plus"></i> Create Supplier</a>

                            {!! Form::close() !!}
                        </div>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">

                            <table class="uk-table uk-table-hover uk-table-striped">
                                <thead>
                                <tr>
                                    <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                                    <th style="background-color: #464646; color: #fff;">Company</th>
                                    <th style="background-color: #464646; color: #fff;">Name</th>
                                    <th style="background-color: #464646; color: #fff;">Contact</th>
                                    <th style="background-color: #464646; color: #fff;">Address</th>
                                    <th style="background-color: #464646; color: #fff;">&nbsp;</th>
                                </tr>
                                </thead>

                                @if(count($suppliers) > 0)
                                    <tbody>
                                    @foreach($suppliers as $supplier)
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $supplier->companyname }}</td>
                                            <td>{{ strtoupper($supplier->lastname) }}, {{ strtoupper($supplier->firstname) }}</td>
                                            <td>{{ $supplier->contactno }}</td>
                                            <td>{{ $supplier->address }}, {{ $supplier->city }}</td>
                                            <td>
                                                <a href="{{ route('supplierEdit', ['id'=>$supplier->supplier_id]) }}" class="uk-button uk-button-mini"><i class="uk-icon-pencil"></i></a>
                                                <a href="{{ route('supplierDestroy', ['id'=>$supplier->supplier_id]) }}" class="uk-button uk-button-mini uk-button-danger del-rec"><i class="uk-icon-times"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6">
                                                <i>{{ count($suppliers) }} - Supplier record found</i>
                                            </td>
                                        </tr>
                                    </tfoot>
                                @endif

                            </table>

                            <div>
                                @include('paginator', ['paginator' => $suppliers])
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

@stop

@section('location') Supplier @stop

@section('js')
    <script type="text/javascript">
        $(function(){
            $('.del-rec').click(function(){
                var r = confirm('Are you sure you want to delete this record?');

                if(!r){
                    return false;
                }
                else
                {
                    var r = confirm('Other related records will also be deleted, proceed?');

                    if(!r){
                        return false;
                    }
                     else
                    {
                        $.ajax({
                            url: '/admin/supplier/destroy/{id}',
                            method: 'get',
                            async: false,
                            data: {
                                _token: '{{ csrf_token() }}',
                                supplier: supplier
                            }
                        }).success(function(r){
                            if(r == 0)
                            {
                                alert('This record can not be deleted!');
                            }
                            else
                            {
                                window.location.reload();
                            }
                        });
                    }
                }
            });
        });
    </script>
@stop