@if (count($errors) > 0)
    <!-- 表單驗證-錯誤訊息 -->
    <div class="alert alert-danger">
        <strong>哎呀! 出了些問題!</strong>
        
        <br>
        
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif