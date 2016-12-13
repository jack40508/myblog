@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">請選擇文章類別</div>

                <div class="panel-body">
                    <select onchange="javascript:location.href=this.value;" name="carlist" form="carform">
                      <option value="/blog" selected="true">所有文章</option>
                      @foreach($essaygroups as $group)
                      
                      @if(!empty($group_id) && $group->group_id == $group_id)
                          <option value="/blog/group/{{$group->group_id}}" selected="true">{{$group->name}}</option>
                          
                          @elseif(!empty($group_id) && $group->group_id != $group_id)
                          <option value="/blog/group/{{$group->group_id}}">{{$group->name}}</option>

                          @else
                          <option value="/blog/group/{{$group->group_id}}">{{$group->name}}</option>    
                      @endif
                      @endforeach
                    </select>
                </div>
            </div>
        

            @foreach($essaies as $essay)
                <div class="panel panel-default">
                    <div class="panel-heading">{{$essay->name}}</div>

                    <div class="panel-body">
                        {{$essay->detail}}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection