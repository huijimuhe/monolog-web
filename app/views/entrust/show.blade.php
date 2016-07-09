@extends('layout.default')
@section('title')
管理角色权限
@stop
@section('breadcrumb')   
<li> <a href="{{URL::route('roles.index')}}">角色管理 </a> </li> <li class="active"> 管理角色权限  </li> 
@stop

@section('content')

<div class="row ">
    <div class="col-lg-8">   
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">基本信息</h3>
            </div>
            <div class="panel-body"> 
                <p>角色名称: {{$role->name}} </p>  
                <p> 角色已有权限：{{ var_dump($role->permissions )}}</p> 
            </div>
        </div>  
    </div> 
</div> 

<div class="row "> 
    <div class="col-lg-12">  
    </div>
</div>
@stop

