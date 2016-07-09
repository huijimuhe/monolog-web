@extends('layout.default')
@section('title')
举报管理
@stop

@section('content') 

<div class="row"> 
    <div class="col-lg-2">
        <button class="btn btn-block btn-social btn-google" id="btn_mulitBanned" 
                data-token="{{csrf_token()}}" data-href="#">
            <i class="fa fa-minus"></i> 批量屏蔽
        </button> 
    </div> 
</div><!-- /.row -->

<div class="row" style="margin-top: 1em;"> 
    <div class="col-lg-12">  
        @if(count($reports)!=0) 
        <table class="table table-bordered table-hover table-striped tablesorter">
            <thead>
                <tr> 
                    <th>编号  </th>
                    <th>举报人 </th> 
                    <th>原因  </th> 
                    <th>内容 </th> 
                    <th>状态</th>
                    <th>操作 </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $r)
                <tr> 
                    <td>{{$r->id}}</td>
                    <td>{{$r->reporter->name or '已删除'}}</td>
                    <td>{{$r->reason}}</a></td>
                    <td>
                        @if($r->statue)
                        <a href="{{ URL::route('statues.show', $r->statue->id) }}">
                            <span >{{$r->statue->text or '已删除'}}</span>
                        </a>
                        @else
                        '已删除'
                        @endif
                    </td>
                    <td>
                        @if($r->isbanned==0)<i class="fa fa-envelope-o text-yellow">未读</i>
                        @elseif($r->isbanned==1)<i class="fa fa-lock text-red">已屏蔽</i>
                        @else<i class="fa fa-unlock text-green">未屏蔽</i>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">操作<span class="caret"></span></button>
                            <ul class="dropdown-menu"> 

                                <li>{{ Form::open(array('route' => array('reports.deal', $r->id), 'method' => 'post', 'data-confirm' => 'Are you sure?')) }}
                                    <button type="submit" class="btn btn-link">屏蔽</button>
                                    {{ Form::close() }}</li> 
                            </ul>
                        </div> 
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>  
        {{$reports->links()}}
        @endif
    </div>  

</div><!-- /.row -->
@stop

@section('scripts')
<!-- Page Specific Plugins -->
<script src="{{asset('plugins/tablesorter/jquery.tablesorter.js')}}"></script>
<script src="{{asset('plugins/tablesorter/tables.js')}}"></script>

@stop