@extends('layout.default')
@section('title')
设置列表
@stop

@section('content') 

<div class="row"> 
    <div class="col-lg-2">
        <a class="btn btn-block btn-social btn-bitbucket" href="{{URL::route('settings.create')}}">
            <i class="fa fa-plus"></i> 新建设置
        </a> 
    </div>
    <div class="col-lg-2">
        <button class="btn btn-block btn-social btn-google" id="btn_mulitDelete" 
                data-token="{{csrf_token()}}" data-href="{{URL::route('settings.mulitDelete')}}">
            <i class="fa fa-minus"></i> 批量删除
        </button> 
    </div> 
</div><!-- /.row -->

<div class="row" style="margin-top: 1em;"> 
    <div class="col-lg-12">  
        @if(count($settings)!=0) 
        <table class="table table-bordered table-hover table-striped tablesorter">
            <thead>
                <tr> 
                    <th>复选  </th>
                    <th>编号</th>
                    <th>名称 </th> 
                    <th>操作 </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($settings as $setting)
                <tr> 
                    <td>{{ Form::checkbox('ids[]',$setting->id) }}</td>
                    <td>{{$setting->id}}</td>
                    <td><a href="{{ URL::route('settings.edit', $setting->id) }}">
                            <span style="display:block;white-space:nowrap; width:100%;overflow:hidden; text-overflow:ellipsis;">{{ $setting->name }}</span>
                        </a>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">操作<span class="caret"></span></button>
                            <ul class="dropdown-menu">  
                                <li>{{ Form::open(array('route' => array('settings.destroy', $setting->id), 'method' => 'delete', 'data-confirm' => 'Are you sure?')) }}
                                    <button type="submit" class="btn btn-link">删除</button>
                                    {{ Form::close() }}</li> 
                            </ul>
                        </div> 
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>  
        {{$settings->links()}}
        @endif
    </div>  

</div><!-- /.row --> 
@stop

@section('scripts')
<!-- Page Specific Plugins -->
<script src="{{asset('plugins/tablesorter/jquery.tablesorter.js')}}"></script>
<script src="{{asset('plugins/tablesorter/tables.js')}}"></script>
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
        alert("未选择设置");
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