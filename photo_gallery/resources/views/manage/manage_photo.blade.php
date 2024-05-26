@extends('layouts.app')

<style>
    *{
        font-family:'微軟正黑體';
    }
    .loading_inner{
        border-radius:50%;
        background-image:linear-gradient(to right,#fff,#0080ff);

        width:30px;
        height:30px;
        margin:auto;

        animation: loading_wrap 4s linear 0s infinite normal;
    }
    @keyframes loading_wrap{
        0% {transform:rotate(0deg);}
        50% {transform:rotate(180deg);}
        100% {transform:rotate(360deg);}
    }

    /* photo_release */
    /* ---------------------------------------------- */
    .photo_release_tittle{
        padding:0px 20px 24px 20px;
        margin-top:20px;

        font-size:26px;
        font-weight:bold;
    }
    .photo_release_wrap{
        width:100%;
        height:85vh;
        /* margin:0 0 40px 0; */

        position:relative;
    }
    .photo_release_mask{
        background:#000;
        opacity:0.5;
        width:100%;
        height:100%;

        position:absolute;
        top:0;
        left:0;
    }
    .photo_release{
        display:flex;

        background:#000;
        width:70vw;
        height:100%;

        position:absolute;
        top:0;
        left:15vw;
    }
    /* upload_photo_area */
    /* -------------------- */
    .photo_release .upload_photo_area{
        width:50%;
        padding:7% 10px 20px 20px;

        color:#fff;
    }
    .photo_release .upload_photo_area .upload_photo_img{
        /* background:url('storage/image/photo/test2.jpeg') center center no-repeat; */
        /* background-size:contain; */
        
        height:56%;
        margin:0 0 20px 0;
        padding-top:25%;

        text-align:center;
    }
    .photo_release .upload_photo_area .upload_photo_img .loading_wrap{
        
    }
    .photo_release .upload_photo_area input[name="upload_photo"]{
        border:1px solid #fff;

        width:100%;
    }
    /* write_photo_content_area */
    /* -------------------- */
    .photo_release .write_photo_content_area{
        width:50%;
        padding:7% 20px 20px 10px;

        color:#fff;
    }
    .photo_release .write_photo_content_area input[name="write_photo_name"]{
        width:100%;
        margin:0 0 20px 0;
    }
    .photo_release .write_photo_content_area textarea[name="write_introduction"]{
        width:100%;
        height:50%;
    }
    .photo_release .write_photo_content_area .release_photo{
        border-radius:10px;
        width:20%;
        padding:10px;

        position:absolute;
        right:40%;
        bottom:9%;
    }

    /* photo_manage */
    /* ---------------------------------------------- */
    .photo_manage_tittle{
        padding:24px 20px 20px 20px;
        margin-top:20px;

        font-size:26px;
        font-weight:bold;
    }
    .photo_manage{
        width:100%;
        /* padding:0 20px; */

        display:flex;
        flex-direction:row;
        justify-content:center;
        flex-wrap:wrap;
        align-items:flex-start;
    }
    .photo_column{
        background:#000;
        border:1px solid #fff;

        width:25%;
        height:50Vh;
        padding:0 0 50px 0;

        position:relative;
    }
    .photo_column:hover .photo_delete{
        visibility:initial;
    }
    .photo_column .photo_img{
        background-size:contain;

        width:100%;
        height:100%;

        cursor:pointer;
    }
    .photo_column .photo_name{
        color:#fff;
    }
    .photo_column .photo_time{
        color:#fff;
    }
    .photo_column .photo_delete{
        background:#000;
        opacity:0.6;
        /* visibility:hidden; */

        padding:0px 10px 5px 10px;

        position:absolute;
        top:0;
        right:0;

        font-size:30px;
        color:#fff;
        line-height:100%;
        cursor:pointer;
    }
    .no_photo{
        padding:8% 0 12% 0;
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
    /* light-box-update_area */
    /* -------------------- */
    .light-box-update_area{
        width:50%;
        padding:40px 20px 20px 20px;

        color:#fff;
    }
    .light-box-update_area .update_photo_column{
        height:46%;
        margin:0 0 1% 0;
    }
    .light-box-update_area .update_photo_column form{
    }
    .light-box-update_area .update_photo_column input[name="update_photo"]{
        border:1px solid #fff;
    }
    .light-box-update_area .update_photo_column .submit_update_photo{
    }
    .light-box-update_area .update_photo_column .update_photo_img{
        width:100%;
        height:70%;
        padding-top:23%;

        text-align:center;
    }
    .light-box-update_area .update_photo_column .update_photo_img .loading_inner{
        margin:-3% auto 0 auto;
    }
    .light-box-update_area .update_introduction_column{
    }
    .light-box-update_area .update_introduction_column form{
        margin:0 0 16px 0;
    }
    .light-box-update_area .update_introduction_column .update_photo_name_title{
        margin:0 0 8px 0;
    }
    .light-box-update_area .update_introduction_column input[name="update_photo_name"]{
        margin:0 0 10px 0;
    }
    .light-box-update_area .update_introduction_column .update_introduction_title{
        margin:0 0 8px 0;
    }
    .light-box-update_area .update_introduction_column textarea[name="update_introduction"]{
        width:100%;
        height:29%;
    }
    .light-box-update_area .update_introduction_column .submit_update_introduction{

    }

</style>

@section('content')
<!-- photo_release -->
<div class="photo_release_tittle">
    發布相片
</div>
<div class="photo_release_wrap">
    <div class="photo_release_mask"></div>

    <div class="photo_release">
        <!-- upload_photo -->
        <div class="upload_photo_area">
            <div class="upload_photo_img">
                upload your photo right now!

                <!-- <div class="loading_wrap">
                    <div class="loading_inner"></div>
                    loading...
                </div> -->
            </div>

            <div>選擇相片</div>
            <form action="" enctype="multipart/form-data">
                <input name="upload_photo" type="file">
            </form>
        </div>

         <!-- write_content -->
        <div class="write_photo_content_area">
            <form action="">
                <label for="write_photo_name">相片標題</label>
                <input type="text" name="write_photo_name" id="write_photo_name"></input>
                
                <label for="write_introduction">相片簡介</label>
                <textarea name="write_introduction" id="write_introduction"></textarea>
            </form>

            <input class="release_photo" type="submit" value="發布相片">
        </div>
    </div>
</div>

<!-- photo_manage -->
<div class="photo_manage_tittle">
    管理相片
</div>
<div class="photo_manage" user_id="{{ Auth::user()->id }}">
    <!-- @for($a=0; $a<$photo_num; $a++)
        <div class="photo_column" photo_id='{{ $all_photo[$a]->id }}'>
            <div class="photo_img" style="background:url('{{ $photo_path.'\\'.$all_photo[$a]->file_name }}') no-repeat center center;background-size:cover;"></div>
            <div class="photo_name">{{ $all_photo[$a]->photo_name }}</div>
            <div class="photo_time">{{ $all_photo[$a]->create_time }}</div>

            <div class="photo_delete">x</div>
        </div>
    @endfor -->
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

    <!-- light-box-update_area -->
    <div class="light-box-update_area">
        <!-- update_photo -->
        <div class="update_photo_column">
            <div>更新相片</div>

            <form action="" enctype="multipart/form-data" onsubmit="return false">
                <input name="update_photo" id="update_photo" type="file">
                <input class="submit_update_photo" type="submit" value="更新相片">
            </form>

            <div class="update_photo_img">
                update your photo right now!
            </div>
        </div>

        <!-- update_introduction -->
        <div class="update_introduction_column">
            <form action="">
                <div>
                    <div class="update_photo_name_title">更新標題</div>
                    <input name="update_photo_name" id="update_photo_name"></input>
                </div>
                <div>
                    <div class="update_introduction_title">更新簡介</div>
                    <textarea name="update_introduction" id="update_introduction"></textarea>
                </div>
            </form>

            <input class="submit_update_introduction" type="submit" value="更新相片資訊">
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

    // upload_photo
    // =========================================
    // select_upload_photo
    $('input[name="upload_photo"]').change(function(){
        $file_prop = $('input[name=upload_photo]').prop('files')[0];
        console.log($file_prop);
        $form = new FormData();
        $form.append('upload_photo',$file_prop);

        // 加載圖示
        $('.upload_photo_img').html(
            '<div class="loading_wrap">'+
                '<div class="loading_inner"></div>'+
                'loading...'+
            '</div>'
        );

        $.ajax({
            type:'post',
            cache: false,
            contentType: false,
            processData: false,
            url:'/manage_photo/upload_photo/preview',
            data:$form,
            success:function(result){
                console.log(result);

                $('.upload_photo_img').text('');
                $('.upload_photo_img').attr({'tmp_photo_name':result['file_name']});
                $('.upload_photo_img').css({'background':'url('+result['file_path']+') no-repeat center center','background-size':'contain'});
            },
            error:function(result){
                console.log(result['responseJSON']);
                console.log(result['status']);

                if(result['status'] == 413){
                    // prompt
                    prompt_faild('上傳照片請勿超過1MB');

                    $('.upload_photo_img').html('upload your photo right now!');
                    $('.upload_photo_img').css('background','');
                    $('.upload_photo_img').removeAttr('tmp_photo_name');
                    $('input[name="upload_photo"]').val('');
                }
            }
        })
    });
    // release_photo
    $('.release_photo').click(function(){
        $tmp_photo_name = $('.upload_photo_img').attr('tmp_photo_name');
        console.log($tmp_photo_name);
        $write_photo_name = $('input[name="write_photo_name"]').val();
        console.log($write_photo_name);
        $write_introduction = $('textarea[name="write_introduction"]').val();
        console.log($write_introduction);
        // validation
        if(text_validation($write_photo_name) == false || text_validation($write_introduction) == false){
            return false;
        }

        $.ajax({
            type:'post',
            url:'/manage_photo/release_photo',
            dataType:'json',
            data:{'tmp_photo_name':$tmp_photo_name, 'write_photo_name':$write_photo_name, 'write_introduction':$write_introduction},
            success:function(result){
                console.log(result);

                // $('.upload_photo_img').html('upload your photo right now!');
                // $('.upload_photo_img').css('background','');
                $('.upload_photo_img').html('photo released!');
                $('.upload_photo_img').removeAttr('tmp_photo_name');
                $('input[name="upload_photo"]').val('');
                $('input[name="write_photo_name"]').val('');
                $('textarea[name="write_introduction"]').val('');
                all_photo();

                // prompt
                prompt_success('發布成功!');
            },
            error:function(result){
                console.log(result['responseJSON']);

                // prompt
                prompt_faild('請選擇相片，並輸入相片標題');
            }
        })
    });

    // manage_photo
    // =========================================
    // all_photo
    function all_photo(){
        $.ajax({
            type:'post',
            url:'/manage_photo/all_photo',
            dataType:'json',
            success:function(result){
                console.log('result: ', result);

                $all_photo = result[0];
                $photo_num = result[1];
                // clear content
                $('.photo_manage').html('');

                if($photo_num != 0){
                    $i = 0;
                    $.each($all_photo,function(){
                        $('.photo_manage').append(
                            '<div class="photo_column" photo_id='+$all_photo[$i]['id']+'>'+
                                '<div class="photo_img" style="background:url(' + $photo_path + '' + $all_photo[$i]['file_name'] + ') no-repeat center center;background-size:cover;"></div>'+
                                '<div class="photo_name">'+$all_photo[$i]['photo_name']+'</div>'+
                                '<div class="photo_time">'+$all_photo[$i]['created_at']+'</div>'+

                                '<div class="photo_delete">x</div>'+
                            '</div>'
                        );
                        console.log('$i: ', $all_photo[$i]);
                        $i++;
                    });
                }else{
                    $('.photo_manage').html('<div class="no_photo">There\'s no photo right now</div>');
                }
            },
        })
    }
    // single_photo
    function single_photo(){
        $.ajax({
            type:'post',
            url:'/all_photo/photo/'+$photo_id,
            dataType:'json',
            data:{'photo_id':$photo_id},
            success:function(result){
                console.log(result);

                $('.light-box-photo_img').css({'background':'url(' + $photo_path + '' + result['file_name']+') center center no-repeat','background-size':'contain'});
                $('.light-box-photo_img').attr('photo_name',result['file_name']);
                $('.light-box-photo_name').children('span').html(' '+result['photo_name']);
                $('.light-box-photo_time').children('span').html(' '+result['created_at']);
                $('.light-box-introduction').html(result['introduction']);

                // update_introduction
                $('.light-box-update_area').attr('photo_id',$photo_id);
                $('.update_introduction_column').find('input[name="update_photo_name"]').val(result['photo_name']);
                $('.update_introduction_column').find('textarea[name="update_introduction"]').val(result['introduction']);
            },
        })
    }

    // delete_photo
    $('.photo_manage').on('click','.photo_delete',function(){
        $photo_id = $(this).parent('.photo_column').attr('photo_id');

        $.ajax({
            type:'post',
            url:'/manage_photo/delete/'+$photo_id,
            dataType:'json',
            data:{'photo_id':$photo_id},
            success:function(result){
                console.log(result);

                all_photo();

                // prompt
                prompt_success('刪除成功!');
            }
        })
    });

    // select_update_photo
    $('input[name="update_photo"]').change(function(){
        $file_prop = $('input[name=update_photo]').prop('files')[0];
        console.log($file_prop);
        $form = new FormData();
        $form.append('update_photo',$file_prop);

        // 加載圖示
        $('.update_photo_img').html(
            '<div class="loading_wrap">'+
                '<div class="loading_inner"></div>'+
                'loading...'+
            '</div>'
        );

        $.ajax({
            type:'post',
            cache: false,
            contentType: false,
            processData: false,
            url:'/manage_photo/update_photo/preview',
            data:$form,
            success:function(result){
                console.log(result);

                $('.update_photo_img').text('');
                $('.update_photo_img').attr({'tmp_photo_name':result['file_name']});
                $('.update_photo_img').css({'background':'url('+result['file_path']+') no-repeat center center','background-size':'contain'});
            },
            error:function(result){
                console.log(result['responseJSON']);
                console.log(result['status']);
                
                if(result['status'] == 413){
                    // prompt
                    prompt_faild('上傳照片請勿超過1MB');
                    
                    $('.update_photo_img').html('update your photo right now!');
                    $('.update_photo_img').css('background','');
                    $('.update_photo_img').removeAttr('tmp_photo_name');
                    $('input[name="update_photo"]').val('');
                }
            }
        })
    });
    // submit_update_photo
    $('.submit_update_photo').click(function(){
        $photo_id = $('.light-box-update_area').attr('photo_id');
        console.log($photo_id);
        $tmp_photo_name = $('.update_photo_img').attr('tmp_photo_name');
        console.log($tmp_photo_name);
        $photo_name = $('.light-box-photo_img').attr('photo_name');
        console.log($photo_name);

        $.ajax({
            type:'post',
            url:'/manage_photo/update_photo/submit/'+$photo_id,
            dataType:'json',
            data:{'photo_name':$photo_name,'tmp_photo_name':$tmp_photo_name},
            success:function(result){
                console.log(result);

                $('.update_photo_img').html('update your photo right now!');
                $('.update_photo_img').css('background','');
                $('.update_photo_img').removeAttr('tmp_photo_name');
                $('input[name="update_photo"]').val('');
                single_photo();
                all_photo();

                // prompt
                prompt_success('更新相片成功!');
            },
            error:function(result){
                console.log(result['responseJSON']);

                // prompt
                prompt_faild('請選擇相片');
            }
        })
    });

    // submit_update_introduction
    $('.submit_update_introduction').click(function(){
        $photo_id = $('.light-box-update_area').attr('photo_id');
        console.log($photo_id);
        $update_photo_name = $('input[name="update_photo_name"]').val();
        console.log($update_photo_name);
        $update_introduction = $('textarea[name="update_introduction"]').val();
        console.log($update_introduction);
        // validation
        if(text_validation($update_photo_name) == false || text_validation($update_introduction) == false){
            return false;
        }


        $.ajax({
            type:'post',
            url:'/manage_photo/update_introduction/'+$photo_id,
            dataType:'json',
            data:{'photo_id':$photo_id, 'update_photo_name':$update_photo_name, 'update_introduction':$update_introduction},
            success:function(result){
                console.log(result);
                
                single_photo();

                // prompt
                prompt_success('更新資訊成功!');
            },
            error:function(result){
                console.log(result['responseJSON']);

                // prompt
                prompt_faild('請輸入更新標題');
            }
        })
    });

    // get_all_photo
    all_photo();

    // into_single_photo
    $('.photo_manage').on('click','.photo_img',function(){
        $('.light-box-mask').css('display','initial');
        $('.light-box').css('display','flex');

        $photo_id = $(this).parent('.photo_column').attr('photo_id');
        // console.log($photo_id);

        single_photo();
    });

    $('.light-box-close').click(function(){
        $('.light-box-mask').css('display','none');
        $('.light-box').css('display','none');
    });

</script>

@endsection
