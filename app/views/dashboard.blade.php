@extends('layout.default')
@section('title')
仪表盘
@stop
@section('breadcrumb')  

@stop

@section('content')  
<div class="row">
    <div class="col-lg-12"> 
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>  
            <p>慧积木合&copy;2016</p> 
			<p><a href="https://github.com/huijimuhe/monolog-web">Github地址</a></p> 
        </div>
    </div>
</div> 
<div class="row"> 
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{$size['uTotal']}}</h3>
                <p>用户总量</p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
            <a href="#" class="small-box-footer">查看<i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col --> 
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{$size['uMonth']}}</h3>
                <p>本月总量</p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
            <a href="#" class="small-box-footer">查看<i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{$size['uWeek']}}</h3>
                <p>本周总量</p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
            <a href="#" class="small-box-footer">查看<i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{$size['uToday']}}</h3>
                <p>今日新增</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">查看<i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
</div> 
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{$size['sTotal']}}</h3>
                <p>独白总量</p>
            </div>
            <div class="icon">
                <i class="fa  fa-hand-spock-o"></i>
            </div>
            <a href="#" class="small-box-footer">查看<i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col --> 
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{$size['sMonth']}}</h3>
                <p>本月总量</p>
            </div>
            <div class="icon">
                <i class="fa  fa-hand-spock-o"></i>
            </div>
            <a href="#" class="small-box-footer">查看<i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{$size['sWeek']}}</h3>
                <p>本周总量</p>
            </div>
            <div class="icon">
                <i class="fa  fa-hand-spock-o"></i>
            </div>
            <a href="#" class="small-box-footer">查看<i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{$size['sToday']}}</h3>
                <p>今日新增</p>
            </div>
            <div class="icon">
                <i class="fa  fa-hand-spock-o"></i>
            </div>
            <a href="#" class="small-box-footer">查看<i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
</div>
@stop
