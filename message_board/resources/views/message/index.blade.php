@extends('layouts.app')

<?php 
// print_r($_COOKIE); 
?>

<style>
.main-wrap{
    width:75%;
    margin:auto;
}
.panel{
    padding:0 15px;
}
.panel-heading{
    margin-bottom:20px;
}
/* 留言 */
.message-table{
    /* margin-top:60px; */
    background:#f7f7f7;
    border-top:1px solid #8080ff;
    border:2px solid #c0c0c0;
}
.message-table th{
    /* border-bottom:1px solid #c0c0c0; */
}
.message-table td{
    width:30%;
}
.message-table td div{
    width:300px;
    word-wrap:break-word;
}
/* 回覆 */
.reply-table{
    background:#ffffff;
    border:1px solid #c0c0c0;
    margin:20px;
}
.reply-table td{
    background:#ffffff;
}
.reply-table td div{
    width:200px;
    word-wrap:break-word;
}
/* 新增留言 */
.add_message_form{
    margin:60px 0 80px 0;
}
</style>

@section('content')
    <div class="main-wrap">
        <!-- 驗證錯誤 -->
        @include('common.errors')

        <!-- 已有留言 -->
        <!-- ======================================================== -->
        @if (count($all_messages) > 0)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>
                        所有留言
                    </h3>
                </div>

                <div class="panel-body">
                    @foreach ($all_messages as $message)
                        <table class="table table-striped message-table">
                            <thead>
                                <th>使用者</th>
                                <th>留言內容</th>
                                <th>留言時間</th>
                                <th></th>
                            </thead>

                            <tbody>
                                <tr>
                                    <td class="table-text">
                                        <div>{{$message->username}}</div>
                                    </td>
                                    <td class="table-text">
                                        <div>{{$message->content}}</div>
                                    </td>
                                    <td class="table-text">
                                        <div>{{$message->created_at}}</div>
                                    </td>

                                    <td>
                                        <!-- 刪除留言 -->
                                        @if (Auth::user()->id == $message->user_id)
                                            <!-- 刪除按鈕 -->
                                            <form action="/message/{{$message->id}}" method="post">
                                                {{csrf_field()}}
                                                {{method_field('DELETE')}}

                                                <button>刪除留言</button>
                                            </form>
                                        @endif

                                        <!-- 調用授權邏輯-blade範例 -->
                                        <!-- ======================================= -->
                                        <!-- 調用AuthServiceProvider授權邏輯 -->
                                        <!-- @can('update-message',$message)
                                            <a href="/message/{{$message->id}}/edit">編輯留言</a>
                                        @else
                                            不可編輯
                                        @endcan -->

                                        <!-- 調用policies授權邏輯 -->
                                        @can('update',$message)
                                            <a href="/message/{{$message->id}}/edit">編輯留言</a>
                                        @endcan

                                    </td>
                                </tr>

                                <!-- 回覆內容 -->
                                <tr>
                                    <td colspan="4">
                                        <table class="reply-table">
                                            @if (isset($replies) && count($replies) != 0 && $replies[0]->message_id == $message->id)
                                                <!-- 收合 -->
                                                <a href="/message">收合</a>

                                                @foreach ($replies as $reply)
                                                    <tr>
                                                        <td class="table-text">
                                                            <div>{{$reply->username}}</div>
                                                        </td>
                                                        <td class="table-text">
                                                            <div>{{$reply->content}}</div>
                                                        </td>
                                                        <td class="table-text">
                                                            <div>{{$reply->created_at}}</div>
                                                        </td>
                                                        <td class="table-text">
                                                            @if (Auth::user()->id === $reply->user_id)
                                                                <form action="/message/{{$message->id}}/{{$reply->id}}" method="post">
                                                                    {{csrf_field()}}
                                                                    {{method_field('DELETE')}}

                                                                    <button>刪除</button>
                                                                </form>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <!-- 查看回覆 -->
                                                <div>共有 {{$all_replys_count[$message->id]}} 則回覆</div>
                                                <a href="/message/{{$message->id}}">查看回覆</a>
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <form action="/message/{{$message->id}}" method="post">
                                            {{csrf_field()}}

                                            <input type="hidden" name="user_id" value="<?=Auth::user()->id?>">
                                            <input type="hidden" name="username" value="<?=Auth::user()->name?>">
                                            <input type="text" name="reply_content">
                                            <input type="hidden" name="time" value="<?=time()?>">
                                            
                                            <button>回覆</button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- 新增留言 -->
        <!-- ======================================================== -->
        <form action="/message" method="post" class="form-horizontal add_message_form">
            {{csrf_field()}}

            <div class="form-group">
                <h3 for="message_content" class="col-sm-3 control-label">新增留言</h3>
                
                <div class="col-sm-6">
                    <input type="hidden" name="username" value="<?=Auth::user()->name?>">
                    <input type="text" name="message_content" class="form-control">
                    <input type="hidden" name="time" value="<?=time()?>">
                </div>
            </div>

            <!-- 新增按鈕 -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="">
                        <i class="fa fa-plus"></i> 新增留言
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection