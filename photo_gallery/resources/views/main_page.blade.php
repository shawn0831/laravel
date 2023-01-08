@extends('layouts.app')

<style>
    *{
        font-family:'微軟正黑體';
    }
    /* layout */
    /* ---------------------------------------------- */
    .wrap{
        display: flex;
    }

    /* navbar */
    /* ---------------------------------------------- */
    .side_nav{
        min-width:20%;
        background: #0080ff;
        /* background-image:linear-gradient(to right, #fff, #0080ff); */
        color:#1380ec;
    }

    /* main */
    /* ---------------------------------------------- */
    .main{
        min-width:80%;

        overflow: hidden;
    }

    /* photo_column */
    /* ---------------------------------------------- */
    .photo_column{
        background:#fff;

        width:40vw;
        height:50vh;
        margin:60px auto 0 auto;
        padding:15px 20px 25px 20px;

        position:relative;

        color:#000;
    }
    .user_name{
    }
    .photo_img{
    }
    .photo_img img{
        background:#000;
        object-fit:contain;

        width:100%;
        height:78%;
        margin:1% 0;

        cursor:pointer;
    }
    .photo_name{
    }
    
    .more_photo{
        width:80px;
        margin:50px auto;

        font-weight:bold;
        color:#004080;
        cursor:pointer;
    }

    /* footer */
    /* ---------------------------------------------- */
    .footer{
        width:80%;
        height:50vh;
        border-radius:50%;
        margin:0 auto 0 auto;
        background-image:linear-gradient(to bottom, #fff, #0080ff);

        transform: translate(0, 30vh);
    }

    /* light-box */
    /* ---------------------------------------------- */

</style>

@section('content')
<div class="wrap" photo_path="{{ $photo_path }}">
    <div class="side_nav"></div>

    <div class="main">
        <!-- photo_column -->
        @foreach($main_photo as $photo)
            <div class="photo_column">
                <div class="user_name">shawn</div>

                <div class="photo_img">
                    <img src="{{ $photo_path.$photo['file_name'] }}" alt="">
                </div>

                <div class="photo_name">{{ $photo['photo_name'] }}</div>
                <div class="photo_comment_num">共有0則評論</div>
            </div>
        @endforeach

        <div class="more_photo">更多動態...</div>

        <div class="footer"></div>
    </div>
</div>


<script>
    // setup
    $photo_path = $('.wrap').attr('photo_path');

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content'),
        },
    });

    // more_photo
    // =========================================
    $('.more_photo').click(function(){
        $.ajax({
            type:'post',
            cache: false,
            contentType: false,
            processData: false,
            url:'/main_page/more_photo',
            data:{'more_photo':'more_photo'},
            success:function(result){
                console.log(result);
                $photo_num = result['photo_num']
                $more_photo = result['more_photo'];

                if($photo_num != 0){
                    $i = 0;
                    $.each($more_photo,function(){
                        $('.wrap').append(
                            '<div class="photo_column">'+
                                '<div class="user_name">Shawn</div>'+

                                '<div class="photo_img">'+
                                    '<img src="'+ $photo_path + $more_photo[$i]['file_name'] +'" alt="">'+
                                '</div>'+

                                '<div class="photo_name">'+ $more_photo[$i]['photo_name'] +'</div>'+
                                '<div class="photo_comment_num">共有0則評論</div>'+
                            '</div>'
                        );
                        console.log($more_photo[$i]);
                        $i++;
                    });
                }
            },
            error:function(result){
                console.log(result['responseJSON']);
                console.log(result['status']);
            }
        })
    });
</script>
@endsection