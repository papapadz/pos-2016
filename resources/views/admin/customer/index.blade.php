@extends('admin')

@section('content')

    <div class="uk-grid">
        <div class="uk-width-1-1">

            <div style="margin-top:20px;">

                <h2>Customer List</h2>

                <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right">
                    {!! Form::open(['method'=>'get', 'class'=>'uk-form']) !!}
                    {!! Form::text('skey', $skey) !!}
                    {!! Form::button('Filter', ['type'=>'submit', 'class'=>'uk-button uk-button-success']) !!}

                    <a href="{{ route('customerCreate') }}" class="uk-button uk-button-primary"><i class="uk-icon-plus"></i> Create Customer</a>
                </div>

                <table class="uk-table uk-table-hover uk-table-striped">
                    <thead>
                    <tr>
                        <th style="background-color: #464646; color: #fff;" width="10">&nbsp;</th>
                        <th style="background-color: #464646; color: #fff;">Company Name</th>
                        <th style="background-color: #464646; color: #fff;">Customer Name</th>
                        <th style="background-color: #464646; color: #fff;">Contact Number</th>
                        <th style="background-color: #464646; color: #fff;">Address</th>
                        <th style="background-color: #464646; color: #fff;" class="uk-text-center">View Details</th>
                        <th style="background-color: #464646; color: #fff;" width="70">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(count($customers) > 0)
                            @foreach($customers as $customer)
                                <tr>
                                    @if($customer->cust_id == 1)
                                        <td>&nbsp;</td>
                                        <td>{{ $customer->companyname }}</td>
                                        <td>{{ strtoupper($customer->lastname) }}</td>
                                        <td>{{ $customer->contactno }}</td>
                                        <td>{{ $customer->address }}</td>
                                        <td width="10">
                                            <a href="{{ route('transactionsIndex', ['id'=>$customer->cust_id]) }}" class="uk-button uk-button-success uk-button-medium">Transactions</a>
                                        </td>
                                        <td>&nbsp;</td>
                                    @else
                                        <td>&nbsp;</td>
                                        <td>{{ $customer->companyname }}</td>
                                        <td>{{ strtoupper($customer->lastname) }}</td>
                                        <td>{{ $customer->contactno }}</td>
                                        <td>{{ $customer->address }}, {{ $customer->city }}</td>
                                        <td width="10">
                                            <a href="{{ route('transactionsIndex', ['id'=>$customer->cust_id]) }}" class="uk-button uk-button-success uk-button-medium">Transactions</a>
                                        </td>
                                        <td class="uk-text-center">
                                            <a href="{{ route('customerEdit', ['id'=>$customer->cust_id]) }}" title="Edit"><i class="uk-icon-pencil"></i></a>
                                            <a href="{{ route('customerDestroy', ['id'=>$customer->cust_id]) }}" class="uk-text-danger del-rec"  title="Delete"><i class="uk-icon-times"></i></a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8"><i>No customer record/s found.</i></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="uk-text-right uk-text-small uk-text-primary">
                    <i>{{ count($customers) }} - Customer record/s found</i>
                </div>
                <div>
                    @include('paginator', ['paginator' => $customers])
                </div>
            </div>

        </div>
    </div>

@stop

@section('location') Customer @stop

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
                }
            });
        });
    </script>
@stop