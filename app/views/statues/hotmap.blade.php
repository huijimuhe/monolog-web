@extends('layout.default')
@section('title')
地图热点
@stop

@section('content')

<div class="row ">  
    <div class="col-lg-12">    
        <div class="box">
            <div class="box-header"> 
                <h3 class="box-title">地图热点 <small>查看独白发送分布</small></h3> 
            </div><!-- /.box-header -->
            <div class="box-body pad">   
                <div class="form-group">  
                </div>
                <div id="baiduMap" style="display:relative;width: 100%;height:45em;background-color: #eeeeee"></div>
            </div>
        </div>
    </div> 
    @stop
    @section('scripts')  
    <script type="text/javascript" src="http://api.map.baidu.com/api?ak=gMQi4OeGZfGDUYNS6i0SSGPb&v=1.5sk=tSvCtnXQe1oGXLxqTdjj7VlZl3gulqNu"></script>
    <script type="text/javascript">
        $(function() {
            //bootstrap WYSIHTML5 - text editor
            // $(".textarea").wysihtml5();
            // 百度地图API功能
            var map = new BMap.Map("baiduMap");            // 创建Map实例 
            var geoc = new BMap.Geocoder();
            map.centerAndZoom("中国", 15);                  // 初始化地图,设置中心点坐标和地图级别。 
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
        });

    </script>
    @stop