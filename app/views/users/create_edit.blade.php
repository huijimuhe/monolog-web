@extends('layout.default')
@section('title')
新建或编辑用户
@stop

@section('content')

<div class="row ">  
    <div class="col-lg-6">    
        <div class="box overlay">
            <div class="box-header"  id="avatar-container"> 
                <h3 class="box-title">头像 <small>上传图片</small></h3>  
                <button type="button" id="pick_avatar" class="btn btn-box-tool pull-right"><i class="fa fa-plus"></i></button>
            </div><!-- /.box-header -->
            <div class="box-body pad">  
                <div class="form-group" id="statue_avatar"  style="display:none;" >  
                    <div class="progress sm">
                        <div id="progress_avatar" class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                        </div>
                    </div> 
                </div>
                <div class="form-group" > 
                    @if (!isset($user))
                    <img class="img-circle" style="width:100%;height:20em" id="img_avatar" />
                    @else
                    <img class="img-circle" id="img-avatar" style="width:150px;height:150px;" src="{{$user->avatar}}" /> 
                    @endif
                </div>
            </div> 
            <div class="overlay" id="overlay_avatar" style="display:none;" >
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div> 
    <div class="col-lg-6">  
        <div class="box">
            <div class="box-header"> 
                <h3 class="box-title">文字、图片 <small>不要超过120字</small></h3> 
            </div><!-- /.box-header -->
            <div class="box-body pad"> 
                <div class="form-group">
                    @if (isset($user))
                    {{$user->statue_count}}/{{$user->right_count}}/{{$user->miss_count}}
                    @endif
                </div>
                @if (isset($user))
                {{ Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'patch']) }} 
                @else
                {{ Form::open(['route' => 'users.store', 'method' => 'post']) }}
                @endif
                {{Form::hidden('avatar',null,['id'=>'hidden_avatar'])}} 
                <div class="form-group">
                    {{ Form::label('name','昵称',array('class' => 'sr-only' )) }} 
                    {{ Form::text('name',null,array('class' => 'form-control','placeholder'=>'请输入昵称' )) }}
                </div>
                <div class="form-group">
                    {{ Form::label('phone','电话号码',array('class' => 'sr-only' )) }} 
                    {{ Form::text('phone',null,array('class' => 'form-control','placeholder'=>'请输入电话号码' )) }}
                </div>
                <div class="form-group">
                    {{ Form::label('password','密码',array('class' => 'sr-only' )) }} 
                    {{ Form::password('password',array('class' => 'form-control','placeholder'=>'请输入密码' )) }}
                </div>
                <div class="form-group">
                    {{ Form::label('gender','性别',array('class' => 'sr-only' )) }} 
                    @if (!isset($user)) 
                    {{App::make('User')->present()->genderSelector}}
                    @else 
                    {{$user->present()->genderSelector}}
                    @endif
                </div> 
            </div>
            <div class="box-footer">
                {{ Form::submit('确定', array('class' => 'btn btn-lg btn-primary btn-block')) }}
                {{Form::close()}}
            </div>
        </div>  
    </div>

</div>
@stop

@section('scripts')
<script type="text/javascript" charset="utf-8" src="{{asset('public/plugins/plupload/plupload.full.min.js')}}"></script>
<script type="text/javascript" charset="utf-8" src="{{asset('public/plugins/plupload/i18n/zh_CN.js')}}"></script>
<script type="text/javascript" charset="utf-8" src="{{asset('public/plugins/qiniu/qiniu.min.js')}}"></script>
<script type="text/javascript" charset="utf-8" src="{{asset('public/plugins/qiniu/qiniu.progress2.js')}}"></script> 
<script type="text/javascript">
//7niu-上传头像
uploadImg('avatar', '{{route('oss.token')}}');
</script>
@stop