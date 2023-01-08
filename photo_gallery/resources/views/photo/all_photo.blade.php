@extends('layouts.app')

<style>
    *{
        font-family:'微軟正黑體';
    }
    /* layout */
    .wrap{
        width:100%;
        /* border:1px solid #000; */
        /* padding:0 1px; */

        display:flex;
        flex-direction:row;
        justify-content:center;
        flex-wrap:wrap;
        align-items:flex-start;
    }
    .column{
        width:25%;
        /* padding:0 1px; */
    }
    .column .photo_column{
        margin:0 0 3px 0;
    }
    .column .photo_column .photo_img img{
        width:100%;

        cursor:pointer;
    }
    .column .photo_column .photo_name{
        padding:0 0 0 2px;
    }
    .column .photo_column .photo_time{
        padding:0 0 0 2px;
    }
    .no_photo{
        padding:18% 0 0 0;
    }

    /* light-box */
    /* ---------------------------------------------- */
    .light-box-mask{
        display:none;

        background:black;
        opacity:0.5;
        width:100vw;
        height:100vh;

        position:fixed;
        top:0vh;
        left:0vw;
    }
    .light-box{
        display:none;

        background:black;
        opacity:1;
        width:80vw;
        height:100vh;

        position:fixed;
        top:0vh;
        left:10vw;
    }
    /* light-box-close */
    .light-box-close{
        width:10px;
        height:10px;

        position:absolute;
        right:20px;

        font-size:30px;
        color:#fff;
        cursor:pointer;
    }
    /* light-box-image_area */
    /* -------------------- */
    .light-box-image_area{
        width:50%;
        height:100%;

        color:#fff;
    }
    .light-box-image_area .light-box-photo_img{
        height:70%;
    }
    .light-box-image_area .light-box-photo_img img{
    }
    .light-box-image_area .light-box-photo_data{
        display:flex;
        justify-content:space-between;

        padding:0 20px 20px 20px;

        position:relative;
    }
    .light-box-image_area .light-box-photo_data .light-box-photo_name{
    }
    .light-box-image_area .light-box-photo_data .light-box-photo_time{
    }
    .light-box-image_area .light-box-introduction{
        padding:0 20px 20px 20px;
    }
    /* light-box-middle_line */
    /* -------------------- */
    .light-box-middle_line{
        border-left:1px solid #fff;

        height:94vh;
        margin:3vh 0 0 0;
    }
    /* light-box-comment_area */
    /* -------------------- */
    .light-box-comment_area{
        /* border-left:1px solid #fff; */
        /* background:#fff; */

        width:50%;
        padding:40px 20px 20px 20px;

        color:#fff;
    }
    .light-box-comment_area .comment_num{
        /* margin:0 0 8px 0; */
    }
    .light-box-comment_area .comment_wrap{
        /* border:1px solid #fff; */

        height:70%;
        margin:0 0 1% 0;

        overflow:auto;
    }
    .light-box-comment_area .comment_row{
        border-bottom:1px solid #000;
        background:#fff;

        position:relative;
        min-height:10%;
        padding:14px 10px 42px 10px;

        color:#000;
        word-wrap:break-word;
    }
    .light-box-comment_area .comment_row .comment_content{
    }
    .light-box-comment_area .comment_row .update_key_in_area{
    }
    .light-box-comment_area .comment_row .update_key_in_area textarea{
        background:#efefef;
        width:100%;
        height:25%;

        margin:10px 0 5px 0;
    }
    .light-box-comment_area .comment_row .comment_row_control{
        position:absolute;
        left:10px;
        bottom:14px;
    }
    .light-box-comment_area .comment_row .comment_data{
        color:#808080;
        font-size:12px;
    }
    .light-box-comment_area .comment_row .delete_comment{
        margin:0 0 0 2px;
        color:#000080;
        font-size:14px;
        cursor:pointer;
    }
    .light-box-comment_area .comment_row .update_comment{
        margin:0 0 0 12px;
        color:#000080;
        font-size:14px;
        cursor:pointer;
    }
    .no_comment{
        margin-top:40%;
        
        text-align:center;
    }
    .light-box-comment_area .write_comment{
    }
    .light-box-comment_area .write_comment textarea{
        width:100%;
        height:13%;
    }
    .light-box-comment_area .write_comment .submit_comment{
    }
</style>

@section('content')
<div class="wrap" user_id="{{ Auth::user()->id }}">
    @if($photo_num==0)
        <div class="no_photo">There's no photo right now</div>
    @else
        <div class="column">
            @for($a=0; $a<$photo_num; $a+=4)
                <div class="photo_column" photo_id='{{ $all_photo[$a]->id }}'>
                    <div class="photo_img">
                        <img src="{{ $photo_path.$all_photo[$a]->file_name }}" alt="">
                    </div>
                    <div class="photo_name"> {{ $all_photo[$a]->photo_name }}</div>
                    <div class="photo_time"> {{ $all_photo[$a]->created_at }}</div>
                </div>
            @endfor
        </div>

        <div class="column">
            @for($a=1; $a<$photo_num; $a+=4)
                <div class="photo_column" photo_id='{{ $all_photo[$a]->id }}'>
                    <div class="photo_img">
                        <img src="{{ $photo_path.$all_photo[$a]->file_name }}" alt="">
                    </div>
                    <div class="photo_name"> {{ $all_photo[$a]->photo_name }}</div>
                    <div class="photo_time"> {{ $all_photo[$a]->created_at }}</div>
                </div>
            @endfor
        </div>

        <div class="column">
            @for($a=2; $a<$photo_num; $a+=4)
                <div class="photo_column" photo_id='{{ $all_photo[$a]->id }}'>
                    <div class="photo_img">
                        <img src="{{ $photo_path.$all_photo[$a]->file_name }}" alt="">
                    </div>
                    <div class="photo_name"> {{ $all_photo[$a]->photo_name }}</div>
                    <div class="photo_time"> {{ $all_photo[$a]->created_at }}</div>
                </div>
            @endfor
        </div>

        <div class="column">
            @for($a=3; $a<$photo_num; $a+=4)
                <div class="photo_column" photo_id='{{ $all_photo[$a]->id }}'>
                    <div class="photo_img">
                        <img src="{{ $photo_path.$all_photo[$a]->file_name }}" alt="">
                    </div>
                    <div class="photo_name"> {{ $all_photo[$a]->photo_name }}</div>
                    <div class="photo_time"> {{ $all_photo[$a]->created_at }}</div>
                </div>
            @endfor
        </div>
    @endif
</div>

<!-- light_box -->
<div class="light-box-mask"></div>

<div class="light-box">
    <div class="light-box-close">x</div>

    <!-- light-box-image_area -->
    <div class="light-box-image_area">
        <div class="light-box-photo_img" photo_path='{{ $photo_path }}'>
        </div>

        <div class="light-box-photo_data">
            <div class="light-box-photo_name">
                標題:<span></span>
            </div>
            <div class="light-box-photo_time">
                上傳時間:<span></span>
            </div>
        </div>

        <div class="light-box-introduction"></div>
    </div>

    <!-- light-box-middle_line -->
    <div class="light-box-middle_line"></div>

    <!-- light-box-comment_area -->
    <div class="light-box-comment_area">
        <div class="comment_num">共有0則評論</div>
        <div class="comment_wrap" comment_id="test">
            <!-- <div class="no_comment">There's no comment right now</div> -->
        </div>

        <div class="write_comment">
            <form action="">
                <label for="comment">寫下留言</label>
                <textarea name="comment" id="comment"></textarea>
            </form>

            <input class="submit_comment" type="submit" value="送出留言">
        </div>
    </div>
</div>

<script>
    // setup
    $photo_path = $('.light-box-photo_img').attr('photo_path');
    // console.log($photo_path);
    $user_id = $(".wrap").attr('user_id');

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content'),
        },
    });

    // single_photo
    function single_photo(){
        $.ajax({
            type:'post',
            url:'/all_photo/photo/'+$photo_id,
            dataType:'json',
            data:{'photo_id':$photo_id},
            success:function(result){
                console.log(result);

                $('.light-box-photo_img').css({'background':'url('+$photo_path+'\\'+result['file_name']+') center center no-repeat','background-size':'contain'});
                $('.light-box-photo_name').children('span').html(' '+result['photo_name']);
                $('.light-box-photo_time').children('span').html(' '+result['created_at']);
                $('.light-box-introduction').html(result['introduction']);
            },
        })
    }
    // all_comment
    function all_comment(){
        $.ajax({
            type:'post',
            url:'/all_photo/comment/'+$photo_id,
            dataType:'json',
            data:{'photo_id':$photo_id},
            success:function(result){
                console.log(result);

                $all_comment = result[0];
                $comment_num = result[1];
                // clear content
                $('.comment_wrap').html('');
                // setup comment_num
                $('.comment_num').html('共有'+$comment_num+'則評論');

                // show comment
                if($comment_num != 0){
                    $i = 0;
                    $.each($all_comment,function(){
                        if($user_id == $all_comment[$i]['user_id']){
                            $('.comment_wrap').append(
                                '<div class="comment_row">'+
                                    '<div class="comment_content">'+$all_comment[$i]['comment']+'</div>'+

                                    '<div class="comment_row_control" comment_id="'+$all_comment[$i]['id']+'">'+
                                        '<span class="comment_data">'+$all_comment[$i]['creater']+' '+$all_comment[$i]['created_at']+'</span>'+
                                        '<span class="update_comment">修改</span>'+
                                        '<span class="delete_comment">刪除</span>'+
                                    '</div>'+
                                '</div>'
                            );
                        }else{
                            $('.comment_wrap').append(
                                '<div class="comment_row">'+
                                    '<div class="comment_content">'+$all_comment[$i]['comment']+'</div>'+
                                    
                                    '<div class="comment_row_control">'+
                                        '<span class="comment_data">'+$all_comment[$i]['creater']+' '+$all_comment[$i]['created_at']+'</span>'+
                                    '</div>'+
                                '</div>'
                            );
                        }
                        // console.log($all_comment[$i]['comment']);
                        $i++;
                    });
                }else{
                    $('.comment_wrap').html('<div class="no_comment">There\'s no comment right now</div>');
                }
                // $('.comment_row').css('word-break','normal');

                // show comment_num
                $('.light-box-comment_area').children('span').html('<span>共有'+$comment_num+'則評論</span>');
            },
        })
    }
    // write_comment
    $('.submit_comment').click(function(){
        $comment = $('.write_comment').find('textarea[name=comment]').val();
        console.log($comment);
        // validation
        if(text_validation($comment) == false){
            return false;
        }

        $.ajax({
            type:'post',
            url:'/all_photo/comment/'+$photo_id+'/write',
            dataType:'json',
            data:{'photo_id':$photo_id,'comment':$comment},
            success:function(result){
                console.log(result);

                all_comment();
                $('.write_comment').find('textarea[name=comment]').val(null);
            },
        });
    });
    // delete_comment
    $('.comment_wrap').on('click','.delete_comment',function(){
        $comment_id = $(this).parent('.comment_row_control').attr('comment_id');
        console.log($comment_id);

        $.ajax({
            type:'post',
            url:'/all_photo/comment/delete/'+$comment_id,
            dataType:'json',
            data:{'comment_id':$comment_id},
            success:function(result){
                console.log(result);

                all_comment();
            },
        });
    });
    // update_comment
    $('.comment_wrap').on('click','.update_comment',function(){
        $comment_content = $(this).parents('.comment_row').children('.comment_content').text();
        console.log($comment_content);

        $('.update_key_in_area').remove();

        $(this).parents('.comment_row').append(
            '<div class="update_key_in_area">'+
                '<textarea name="update" id="update">'+$comment_content+'</textarea>'+
                '<input class="submit_update" type="submit" value="確定修改">'+
            '</div>'
        );
    });
    // submit_update
    $('.comment_wrap').on('click','.submit_update',function(){
        $comment_id = $(this).parent('.update_key_in_area').siblings('.comment_row_control').attr('comment_id');
        console.log($comment_id);
        $comment_update = $('textarea[name=update]').val();
        console.log($comment_update);
        // validation
        if(text_validation($comment_update) == false){
            return false;
        }

        $.ajax({
            type:'post',
            url:'/all_photo/comment/update/'+$comment_id,
            dataType:'json',
            data:{'comment_id':$comment_id,'comment_update':$comment_update},
            success:function(result){
                console.log(result);

                all_comment();
            },
        });
    });

    // into_single_photo
    $('.photo_img').click(function(){
        $('.light-box-mask').css('display','initial');
        $('.light-box').css('display','flex');

        $photo_id = $(this).parent('.photo_column').attr('photo_id');
        // console.log($photo_id);

        single_photo();
        all_comment();
    });

    $('.light-box-close').click(function(){
        $('.light-box-mask').css('display','none');
        $('.light-box').css('display','none');
    });
</script>

@endsection

<?php
// ddd
?>