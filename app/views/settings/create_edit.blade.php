@extends('layout.default')
@section('title')
新建或编辑设置
@stop

@section('content')

<div class="row "> 
    @if (isset($setting))
    {{ Form::model($setting, ['route' => ['settings.update', $setting->id], 'method' => 'patch']) }}
    @else
    {{ Form::open(['route' => 'settings.store', 'method' => 'post', 'files' => true]) }}
    @endif  

    <div class="col-lg-12">    
        <div class="box">
            <div class="box-header"> 
                <h3 class="box-title">内容 </h3> 
            </div><!-- /.box-header -->
            <div class="box-body pad">   
                <div class="form-group">
                    {{ Form::label('name','名称',array('class' => 'sr-only' )) }} 
                    {{ Form::text('name',null,array('class' => 'form-control','placeholder'=>'请输入名称' )) }}
                </div>
                <div class="form-group">
                    {{ Form::textarea('val', null, ['class' => 'textarea',
                                            'rows' => 10,
                                            'style' => "width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;", 
                                            'placeholder' => '值1']) }}   
                </div>
                <div class="form-group">
                    {{ Form::label('val2','值2',array('class' => 'sr-only' )) }} 
                    {{ Form::text('val2',null,array('class' => 'form-control','placeholder'=>'值2' )) }}
                </div>
                <div class="form-group">
                    {{ Form::label('val3','值3',array('class' => 'sr-only' )) }} 
                    {{ Form::text('val3',null,array('class' => 'form-control','placeholder'=>'值3' )) }}
                </div>
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
     $(".textarea").wysihtml5();
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