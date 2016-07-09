@extends('layout.default')
@section('title')
角色列表
@stop
@section('breadcrumb')   
<li class="active"><i class="fa fa-edit"></i> 角色管理  </li>
@stop

@section('content') 

@include('entrust.partials.sidebar')

<div class="row">  
    <div class="col-lg-12">
        <div class="page-header">
            <h1 id="indicators">角色信息</h1>
        </div>
    </div>
    {{ Form::open(array('route' => array('roles.createRole'), 'method' => 'post', 'data-confirm' => 'Are you sure?')) }}
    <div class="col-lg-2">    
        {{ Form::label('name','名称',array('class' => 'sr-only' )) }} 
        {{ Form::text('name',null,array('class' => 'form-control','placeholder'=>'新角色名称' )) }}
    </div> 
    <div class="col-lg-2">  
        {{ Form::submit('新建角色', array('class' => 'btn  btn-primary ')) }}
    </div>  
    {{ Form::close() }} 
    <div class="col-lg-6"> 
        <div class="form-group input-group">
            <input type="text" class="form-control">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
            </span>
        </div>
    </div>
</div><!-- /.row -->

<div class="row"> 
    <div class="col-lg-12">  
        @if(isset($roles))
        {{ $roles->links() }}
        <table class="table table-bordered table-hover table-striped tablesorter">
            <thead>
                <tr>  
                    <th>名称  </th>  
                    <th>权限  </th>  
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                <tr> 
                    <td><a href="{{ URL::route('roles.show', $role->id) }}">{{ $role->name }}</a></td>  
                    <td>"""</td>  
                </tr>
                @endforeach
            </tbody>
        </table> 
        {{ $roles->links() }}
        @endif
    </div>  

</div><!-- /.row -->

<div class="row">  
    <div class="col-lg-12">
        <div class="page-header">
            <h1 id="indicators">权限信息</h1>
        </div>
    </div>
    {{ Form::open(array('route' => array('roles.createPerm'), 'method' => 'post', 'data-confirm' => 'Are you sure?')) }}
    <div class="col-lg-2">    
        {{ Form::label('name','名称',array('class' => 'sr-only' )) }} 
        {{ Form::text('name',null,array('class' => 'form-control','placeholder'=>'权限名称' )) }}
    </div> 
    <div class="col-lg-2">    
        {{ Form::label('display_name','名称',array('class' => 'sr-only' )) }} 
        {{ Form::text('display_name',null,array('class' => 'form-control','placeholder'=>'显示名称' )) }}
    </div> 
    <div class="col-lg-2">  
        {{ Form::submit('新建权限', array('class' => 'btn  btn-primary ')) }}
    </div>  
    {{ Form::close() }} 
    <div class="col-lg-6"> 
        <div class="form-group input-group">
            <input type="text" class="form-control">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
            </span>
        </div>
    </div>
</div><!-- /.row -->

<div class="row"> 
    <div class="col-lg-12">  
        @if(isset($perms))
        {{ $perms->links() }}
        <table class="table table-bordered table-hover table-striped tablesorter">
            <thead>
                <tr>  
                    <th>名称  </th>  
                    <th>显示名  </th>  
                </tr>
            </thead>
            <tbody>
                @foreach ($perms as $perm)
                <tr> 
                    <td> {{ $perm->name }}</a></td>  
                    <td> {{ $perm->display_name }}</a></td>  
                </tr>
                @endforeach
            </tbody>
        </table> 
        {{ $perms->links() }}
        @endif
    </div>  

</div><!-- /.row -->

@stop

@section('scripts')
<!-- Page Specific Plugins -->
<script src="{{asset('js/tablesorter/jquery.tablesorter.js')}}"></script>
<script src="{{asset('js/tablesorter/tables.js')}}"></script>

@stop
