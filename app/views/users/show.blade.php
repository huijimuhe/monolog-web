@extends('layout.default')
@section('title')
用户资料
@stop

@section('content') 

<div class="row"> 
    <div class="col-lg-3"> 
        <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-green">
                <div class="widget-user-image">
                    <img class="img-circle" id="img-avatar" src="{{$user->avatar}}" /> 
                </div><!-- /.widget-user-image -->
                <h3 class="widget-user-username">{{$user->name}}</h3>
                <h5 class="widget-user-desc">{{$user->phone or "无电话"}}</h5>
                <h5 class="widget-user-desc">{{$user->created_at}}</h5> 
                <h5 class="widget-user-desc">{{$user->profile->gender=='m'?"女":"男"}}</h5>
            </div>
            <div class="box-footer no-padding">
                <ul class="nav nav-stacked">

                    <li><a href="#">独白数量 <span class="pull-right badge bg-blue">{{$user->statues  or $user->statues->count() }}</span></a></li>
                    <li><a href="#">关注数量 <span class="pull-right badge bg-green">{{$user->followers  or $user->followers->count() }}</span></a></li>
                    <li><a href="#">粉丝数量 <span class="pull-right badge bg-blue">{{$user->fans  or $user->fans->count() }}</span></a></li>
                    <li><a href="#">举报数量 <span class="pull-right badge bg-green">{{$user->reports  or $user->reports->count() }}</span></a></li> 
                </ul>
            </div>
        </div>
    </div> 
    <div class="col-lg-9">  
        @if(isset($user->statues)) 
        <table class="table table-bordered table-hover table-striped tablesorter">
            <thead>
                <tr>
                    <th>编号 </th>
                    <th>内容  </th> 
                    <th>属性 </th> 
                    <th>操作 </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user->statues as $statue)
                <tr>
                    <td>{{ $statue->id }}</td> 
                    <td><a href="{{ URL::route('statues.show', [$statue->id]) }}">
                            <span style="display:block;white-space:nowrap; width:20em;overflow:hidden; text-overflow:ellipsis;">{{ $statue->text }}</span></a></td>
                    <td>{{$statue->isbanned?"是":"否"}}</td> 
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">操作<span class="caret"></span></button>
                            <ul class="dropdown-menu"> 

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
        @endif 
    </div>  
</div>  
@stop

@section('scripts')
<!-- Page Specific Plugins -->
<script src="{{asset('js/tablesorter/jquery.tablesorter.js')}}"></script>
<script src="{{asset('js/tablesorter/tables.js')}}"></script>

@stop