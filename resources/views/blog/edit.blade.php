@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">新建文章</div>

                <div class="panel-body">
                    {!!Form::open(['url'=>'/blog/'.$essay->id,'method'=>'patch'])!!}
                        <div class="form-group">
                            {!!Form::label('文章名稱')!!}
                            {!!Form::text('input_name',$essay->name,['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group">
                            {!!Form::label('文章類別')!!}
                            {!!Form::text('input_group',$essay->group_name,['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group">
                            {!!Form::label('請輸入文章內容')!!}
                            {!!Form::textarea('input_message',$essay->detail,['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            {!!Form::submit('確認編輯',['class'=>'btn btn-primary'])!!}
                        </div>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection