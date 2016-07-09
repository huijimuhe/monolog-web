@extends('layout.default')
@section('title')
新建或编辑独白
@stop

@section('content')

<div class="row "> 
    @if (isset($statue))
    {{ Form::model($statue, ['route' => ['statues.update', $statue->id], 'method' => 'patch']) }}
    @else
    {{ Form::open(['route' => 'statues.store', 'method' => 'post', 'files' => true]) }}
    @endif  

    <div class="col-lg-4">    
        <div class="box">
            <div class="box-header"> 
                <h3 class="box-title">地图选点 <small>直接地图点击</small></h3> 
            </div><!-- /.box-header -->
            <div class="box-body pad">  
                <div class="input-group">
                    <input type="text" id="txt_geo" class="form-control" placeholder="搜索必须有城市名称如‘成都万象城’">
                    <span class="input-group-btn">
                        <button type="button" id="btn_geo" class="btn btn-flat"><i class="fa fa-search"></i></button>
                    </span>  
                </div>
                <div class="form-group"> 
                    @if (!isset($statue))
                    <p><strong>经度:</strong><small id="lng-txt"></small> <strong>纬度:</strong><small id="lat-txt"></small><strong>地址:</strong><small id="address-txt"></small> </p>
                    @else
                    <p><strong>经度:</strong><small id="lng-txt"></small> <strong>纬度:</strong><small id="lat-txt"></small><strong>地址:</strong><small id="address-txt"></small> </p>
                    @endif
                </div>
                <div id="baiduMap" style="display:relative;width: 100%;height:25em;background-color: #eeeeee"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">    
        <div class="box overlay">
            <div class="box-header"  id="img-container"> 
                <h3 class="box-title">配图 <small>上传图片</small></h3>  
                <button type="button" id="pick_img" class="btn btn-box-tool pull-right"><i class="fa fa-plus"></i></button>
            </div><!-- /.box-header -->
            <div class="box-body pad">  
                <div class="form-group" id="statue_img"  style="display:none;" >  
                    <div class="progress sm">
                        <div id="progress_img" class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                        </div>
                    </div> 
                </div>
                <div class="form-group bg-yellow" > 
                    @if (!isset($statue))
                    <img class="" style="width:100%;height:20em" id="img_img" />
                    @else
                    {{$statue->present()->backgroundImg}}
                    @endif
                </div>
            </div> 
            <div class="overlay" id="overlay_img" style="display:none;" >
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-4">    
        <div class="box">
            <div class="box-header"> 
                <h3 class="box-title">文字、图片 <small>随机生成机器人</small></h3> 
            </div><!-- /.box-header -->
            <div class="box-body pad"> 
                <h5><i class="fa fa-user"></i>{{$u->name}}</h5>
                {{Form::hidden('user_id',$u->id)}} 
                {{Form::hidden('lng',null,['id'=>'hidden-lng'])}} 
                {{Form::hidden('lat',null,['id'=>'hidden-lat'])}} 
                {{Form::hidden('img_path',null,['id'=>'hidden_img'])}} 
                {{ Form::textarea('text', null, ['class' => 'textarea',
                                            'rows' => 10,
                                            'style' => "width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;", 
                                            'placeholder' => '独白内容']) }}      
            </div>
            <div class="box-footer">
                {{ Form::submit('确定', array('class' => 'btn btn-lg btn-primary btn-block')) }} 
            </div>
        </div>
        <!-- general form elements --> 
        {{Form::close()}} 
    </div>
    @stop
    @section('scripts')
    <script type="text/javascript" charset="utf-8" src="{{asset('plugins/plupload/plupload.full.min.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('plugins/plupload/i18n/zh_CN.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('plugins/qiniu/qiniu.min.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('plugins/qiniu/qiniu.progress2.js')}}"></script> 
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>  
    <script type="text/javascript" src="http://api.map.baidu.com/api?ak=gMQi4OeGZfGDUYNS6i0SSGPb&v=1.5sk=tSvCtnXQe1oGXLxqTdjj7VlZl3gulqNu"></script>
    <script type="text/javascript">
$(function() {
    //bootstrap WYSIHTML5 - text editor
   // $(".textarea").wysihtml5();
    // 百度地图API功能
    var map = new BMap.Map("baiduMap");            // 创建Map实例 
    var geoc = new BMap.Geocoder();
    map.centerAndZoom("成都", 15);                  // 初始化地图,设置中心点坐标和地图级别。 
    function showInfo(e) {
        map.clearOverlays();
        var marker = new BMap.Marker(new BMap.Point(e.point.lng, e.point.lat));
        $('#lng-txt').text(e.point.lng);
        $('#lat-txt').text(e.point.lat);
        $('#hidden-lng').val(e.point.lng);
        $('#hidden-lat').val(e.point.lat);
        map.addOverlay(marker);
        geoc.getLocation(e.point, function(rs) {
            $('#address-txt').text(rs.address);
        });
    }
    map.addEventListener("click", showInfo);
    $('#btn_geo').click(function() {
        map.clearOverlays();
        var query = $("#txt_geo").val();
        geoc.getPoint(query, function(point) {
            if (point) {
                map.centerAndZoom(point, 16);
                map.addOverlay(new BMap.Marker(point));
                $('#lng-txt').text(point.lng);
                $('#lat-txt').text(point.lat);
                $('#hidden-lng').val(point.lng);
                $('#hidden-lat').val(point.lat);
                geoc.getLocation(point, function(rs) {
                    $('#address-txt').text(rs.address);
                });
            } else {
                $('#address-txt').text("您选择地址没有解析到结果!");
            }
        });
    });

    //7niu-上传图片
    uploadImg('img', '{{route('oss.token')}}');
});

    </script>
    @stop