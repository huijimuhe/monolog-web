@extends('layout.default')
@section('title')
独白列表
@stop

@section('content') 

<div class="row"> 
    <div class="col-lg-2">
        <a class="btn btn-block btn-social btn-bitbucket" href="{{URL::route('statues.create')}}">
            <i class="fa fa-plus"></i> 新建秘密
        </a> 
    </div>
    <div class="col-lg-2">
        <button class="btn btn-block btn-social btn-google" id="btn_mulitDelete" 
                data-token="{{csrf_token()}}" data-href="{{URL::route('statues.mulitDelete')}}">
            <i class="fa fa-minus"></i> 批量删除
        </button> 
    </div>
    <div class="col-lg-2">
        <a class="btn btn-block btn-social btn-github" id="btn_mulitBlock" href="javascript::void(0)">
            <i class="fa fa-lock"></i> 批量屏蔽
        </a> 
    </div>
</div><!-- /.row -->

<div class="row" style="margin-top: 1em;"> 
    <div class="col-lg-12">  
        @if(count($statues)!=0) 
        <table class="table table-bordered table-hover table-striped tablesorter">
            <thead>
                <tr> 
                    <th>复选  </th>
                    <th>内容  </th>
                    <th>坐标</th>
                    <th>对/错</th>
                    <th>发布人 </th>  
                    <th>状态 </th> 
                    <th>操作 </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($statues as $statue)
                <tr> 
                    <td>{{ Form::checkbox('ids[]',$statue->id) }}</td>
                    <td><a href="{{ URL::route('statues.show', $statue->id) }}">
                          {{ $statue->text }}
                        </a></td>
                    <td>{{$statue->poi[0]}}/{{$statue->poi[1]}}</td>
                    <td>{{$statue->right_count}}/{{$statue->miss_count}}</td>
                    <td>{{$statue->user_id}}</td>
                    <td><a href="{{ URL::route('users.show', $statue->user_id) }}">{{$statue->user==null?'已删除': $statue->user->name }}</a></td>
                    <td>{{$statue->isbaned==0?'<i class="fa fa-unlock text-green"></i>':'<i class="fa fa-lock text-red"></i>'}}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">操作<span class="caret"></span></button>
                            <ul class="dropdown-menu"> 
                                <li>{{ Form::open(array('route' => array('statues.destroy', $statue->id), 'method' => 'delete', 'data-confirm' => 'Are you sure?')) }}
                                    <button type="submit" class="btn btn-link">举报</button>
                                    {{ Form::close() }}</li> 
                                <li>{{ Form::open(array('route' => array('statues.destroy', $statue->id), 'method' => 'delete', 'data-confirm' => 'Are you sure?')) }}
                                    <button type="submit" class="btn btn-link">删除</button>
                                    {{ Form::close() }}</li> 
                            </ul>
                        </div> 
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>  
        {{$statues->links()}}
        @endif
    </div>  

</div><!-- /.row -->

<div class="row"> 
    <div class="col-lg-2">
        <a class="btn btn-block btn-social btn-bitbucket" href="{{URL::route('statues.create')}}">
            <i class="fa fa-plus"></i> 新建秘密
        </a> 
    </div>
    <div class="col-lg-2">
        <a class="btn btn-block btn-social btn-google" id="btn_mulitDelete" href="javascript::void(0)">
            <i class="fa fa-minus"></i> 批量删除
        </a> 
    </div>
    <div class="col-lg-2">
        <a class="btn btn-block btn-social btn-github" id="btn_mulitBlock" href="javascript::void(0)">
            <i class="fa fa-lock"></i> 批量屏蔽
        </a> 
    </div>
</div><!-- /.row -->
@stop

@section('scripts')
<!-- Page Specific Plugins -->
<script src="{{asset('public/plugins/tablesorter/jquery.tablesorter.js')}}"></script>
<script src="{{asset('public/plugins/tablesorter/tables.js')}}"></script>
<script>
$('#btn_mulitDelete').click(function(e) {
    e.preventDefault();
    var _ids = new Array();
    var _url = $(this).attr('data-href'),
            _btn = $(this),
            _token = $(this).attr('data-token');
    //获得选中的input 
    $('input[type="checkbox"][name="ids[]"]:checked').each(function() {
        _ids.push($(this).val());
    });
    if (_ids.length == 0) {
        alert("未选择独白");
        return false;
    }
    if (confirm('您确定要执行此操作吗？请慎重！') == true) {
        _btn.attr("disabled", true);
        $.ajax({
            type: 'POST',
            url: _url,
            data: {'_token': _token, 'ids': _ids},
            dataType: 'json',
            beforeSend: function() {
                _btn.attr("disabled", true);
            },
            success: function(data) {
                location.reload();
                _btn.attr("disabled", false);
            },
            error: function(e, a, b) {
                if (e.status == 200) {
                    location.reload();
                } else {
                    alert('出错了，请稍候再试....');
                }
                _btn.attr("disabled", false);
            }
        });
    }
    return false;
});
</script>
@stop