@extends('accountant')

@section('content')
    <div style="background-color: #e2e2e2; padding: 8px;">
        <div style="background-color: #FFF; padding: 3px;">

            <div class="uk-grid">
                <div class="uk-width-1-1">

                    <div style="margin-top:15px;">

                        <h2>Customer List</h2>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-right" style="background-color: #e5e4e4;">
                            {!! Form::open(['method'=>'get', 'class'=>'uk-form']) !!}
                            {!! Form::text('skey', $skey) !!}
                            {!! Form::button('Filter', ['type'=>'submit', 'class'=>'uk-button uk-button-success']) !!}

                            <a href="{{ route('accountantCustomerCreate') }}" class="uk-button uk-button-primary"><i class="uk-icon-plus"></i> Create Customer</a>
                        </div>

                        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-small-top">

                            <table class="uk-table uk-table-hover uk-table-striped">
                                <thead>
                                <tr style="background-color: #464646; color: #fff;">
                                    <th>&nbsp;</th>
                                    <th>Company</th>
                                    <th>Name</th>
                                    <th>Contact Number</th>
                                    <th>Address</th>
                                    <th>Type</th>
                                    <th width="50">&nbsp;</th>
                                </tr>
                                </thead>

                                @if(count($customers) > 0)
                                    <tbody>
                                    @foreach($customers as $customer)
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $customer->companyname }}</td>
                                            <td>{{ strtoupper($customer->firstname) }} {{ strtoupper($customer->lastname) }}</td>
                                            <td>{{ $customer->contactno }}</td>
                                            <td>{{ $customer->city }}</td>
                                            <td>{{ ($customer->cust_type == 1 ? 'Government' : 'Non-Government') }}</td>
                                            <td class="uk-text-right">
                                                <a href="{{ route('accountantTransactionsIndex', ['id'=>$customer->cust_id]) }}" class="uk-button uk-button-success uk-button-medium">Transactions</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="8"><i>{{ count($customers) }} - Customer record/s found</i></td>
                                    </tr>
                                    </tfoot>
                                @else
                                    <tfoot>
                                    <tr>
                                        <td colspan="8"><i>No customer record/s found.</i></td>
                                    </tr>
                                    </tfoot>
                                @endif

                            </table>

                            <div>
                                @include('paginator', ['paginator' => $customers])
                            </div>

                        </div>

                    </div>

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
                    else
                    {
                        $.ajax({
                            url: '/admin/customer/destroy/{id}',
                            method: 'get',
                            async: false,
                            data: {
                                _token: '{{ csrf_token() }}',
                                customer: customer
                            }
                        }).success(function(r){
                            if(r == 0)
                            {
                                alert('Record can not be deleted!');
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