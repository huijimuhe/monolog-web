@extends('layout.default')
@section('title')
独白详情
@stop 
@section('content')  
<div class="row ">
    <div class="col-lg-12">
        <div class="box box-widget">
            <div class="box-header with-border">
                <div class="user-block">
                    {{$statue->user or $statue->user->present()->avatar}} 
                    <span class="username">{{$statue->user->name or '已删除'}}</span>
                    <span class="description">{{$statue->created_at}}</span>
                </div><!-- /.user-block -->
            </div><!-- /.box-header -->
            <div class="box-body">
                @if (!isset($statue))
                <img class="bg-yellow" style="width:100%;height:20em;" id="img-background" />
                @else
                {{$statue->present()->backgroundImg}}
                @endif 
                <p>{{$statue->text}}</p> 
                <div id="baiduMap" style="display:relative;width: 100%;height:15em;background-color: #eeeeee"></div>
                <button type="button" class="btn btn-default btn-xs"><i class="fa fa-user"></i> {{$statue->guess->count()}}</button>
                @if ($statue->isbanned)
                <button type="button" class="btn btn-default btn-xs"><i class="fa fa-lock text-red"></i>被举报</button>
                @else
                <button id="btn_banned" type="button" class="btn btn-default btn-xs"><i class="fa fa-unlock text-green"></i> 未举报</button>
                @endif
            </div><!-- /.box-body -->
            <div class="box-footer box-comments">
                @foreach($statue->guess as $g)
                <div class="box-comment">
                    <!-- User image -->
                    {{$g->user or $g->user->present()->avatar}} 
                    <div class="comment-text">
                        <span class="username">
                            {{$g->user->name or '已删除'}}
                            <span class="text-muted">{{$g->created_at}}</span>
                        </span><!-- /.username -->
                        {{$g->user->result==1?"<i class=\"fa fa-circle-o text-green\"></i>" :"<i class=\"fa fa-circle-o text-red\"></i>"}}
                    </div><!-- /.comment-text -->
                </div><!-- /.box-comment --> 
                @endforeach
            </div> 
        </div>  
    </div>
</div> <!-- /.row -->

@stop

@section('scripts')  
<script type="text/javascript" src="http://api.map.baidu.com/api?ak=gMQi4OeGZfGDUYNS6i0SSGPb&v=1.5sk=tSvCtnXQe1oGXLxqTdjj7VlZl3gulqNu"></script>
<script type="text/javascript">
        $(function() {
        var map = new BMap.Map("baiduMap"); // 创建Map实例 
                var geoc = new BMap.Geocoder();
                var point = new BMap.Point({{$statue -> lng}}, {{$statue -> lat}});
                map.centerAndZoom(point, 15); // 初始化地图,设置中心点坐标和地图级别。 
                var marker = new BMap.Marker(point);
                map.addOverlay(marker);
        });

</script>
@stop