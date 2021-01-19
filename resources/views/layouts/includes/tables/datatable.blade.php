{{--
    $list_name
    $table_id
    $table_columns_name
    $action (not required)

    //
    we need to pass this two varibale to have access to add butyon
    $add_route
    $add_btn_text
--}}
<div class="col-lg-12">
    <div class="card card-default text-dark">
        <div class="card-header justify-content-between">
            <h2>{{ $list_name }}</h2>
            @if(isset($add_route) && isset($add_btn_text) )
                <a role="button" class="btn btn-lg btn-info" href="{{ $add_route }}">
                    <i class="fa fa-plus mr-1" aria-hidden="true">
                    </i>
                    {{ $add_btn_text }}
                </a>
            @endif
        </div>
        <div class="py-4">
            <table id="{{ $table_id }}" class="table table-bordered data-table" style="width:100%">
                <thead>
                    <tr>
                        @foreach($table_columns_name as $name)
                            <th>{{ $name }}</th>
                        @endforeach
                        @if(isset($action) && $action)
                            <th width="30px"></th>
                            {{-- <th width="100px">Action</th> --}}
                        @endif
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
