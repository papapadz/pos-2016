@extends('admin')

@section('content')
<div class="uk-grid">
    <div class="uk-width-1-1">

        <div style="margin-top:15px;">
            <div uk-grid>
                <div class="uk-width-1-2"><h2>Category List</h2></div>
                <div class="uk-width-1-2 uk-text-right">
                    {!! Form::open(['method'=>'get', 'class'=>'uk-form']) !!}
                    {!! Form::text('skey', $skey, ['placeholder' => 'Category']) !!}
                    {!! Form::button('Filter ', ['type'=>'submit', 'class'=>'uk-button uk-button-primary uk-button-small', 'uk-icon="icon: search"']) !!}
                    <a class="uk-button uk-button-small" style="background: limegreen; color: white;" href="{{ route('categoryCreate') }}" uk-icon="icon: plus-circle">New </a>
                </div>
            </div>

            <div class="uk-panel uk-panel-box uk-panel-box-secondary">

                <table class="uk-table uk-table-hover uk-table-striped">
                    <thead>
                    <tr>
                        <th style="background-color: #464646; color: #fff;">Category</th>
                        <th style="background-color: #464646; color: #fff;">Description</th>
                        <th style="background-color: #464646; color: #fff;">Action</th>
                    </tr>
                    </thead>

                    
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->categoryname }}</td>
                                <td>{{ $category->description }}</td>
                                <td>
                                    <a href="{{ route('categoryEdit', ['id'=>$category->category_id]) }}" class="uk-button uk-button-small uk-button-primary" uk-icon="icon: pencil"></a>
                                    <a href="{{ route('categoryDestroy', ['id'=>$category->category_id]) }}" class="uk-button uk-button-small uk-button-danger del-rec" uk-icon="icon: close"></a>
                                </td>
                            </tr>
                        @endforeach
                            
                        </tbody>
                </table>
            </div>

        </div>

    </div>
</div>
@stop

@section('location') Category @stop

@section('js')
<script>
    $('table.uk-table').DataTable()
</script>
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
                            url: '/admin/category/destroy/{id}',
                            method: 'get',
                            async: false,
                            data: {
                                _token: '{{ csrf_token() }}',
                                category: category
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