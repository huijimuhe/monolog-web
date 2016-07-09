@extends('layout.default')
@section('title')
用户列表
@stop 
@section('content') 
<div class="row"> 
    <div class="col-lg-12">
        <a class="btn btn-block btn-social btn-bitbucket" href="{{URL::route('users.create')}}">
            <i class="fa fa-plus"></i> 新建用户
        </a> 
    </div>

</div><!-- /.row --> 

<div class="row"> 
    <div class="col-lg-12">  
        @if(isset($users))
        {{ $users->links() }}
        <table class="table table-bordered table-hover table-striped tablesorter">
            <thead>
                <tr>  
                    <th>姓名  </th>
                    <th>性别  </th>
                    <th>微信号  </th> 
                    <th>是否被屏蔽  </th>
                    <th>创建时间  </th>
                    <th>操作 </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr> 
                    <td><a href="{{ URL::route('users.show', $user->id) }}">{{ $user->name }}</a></td>
                    <td>{{ $user->gender=='m' ?'男':'女'}} </td>
                    <td>{{ $user->app_token }} </td>
                    <td>{{ $user->isbanned}} </td>
                    <td>{{ $user->created_at }}</td>
                    <td>
                        <a href="{{ URL::route('users.edit', $user->id) }}" class="btn btn-success btn-mini pull-left">编辑</a>

                        {{ Form::open(array('route' => array('users.destroy', $user->id), 'method' => 'delete', 'data-confirm' => 'Are you sure?')) }}
                        <button type="submit" href="{{ URL::route('users.destroy', $user->id) }}" class="btn btn-danger btn-mini">删除</button>
                        {{ Form::close() }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table> 
        {{ $users->links() }}
        @endif
    </div>  

</div><!-- /.row -->
@stop

@section('scripts')
<!-- Page Specific Plugins -->
<script src="{{asset('public/plugins/tablesorter/jquery.tablesorter.js')}}"></script>
<script src="{{asset('public/plugins/tablesorter/tables.js')}}"></script>

@stop
