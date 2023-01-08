<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Photo;
use App\Comment;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{
    public $last_photo_id;

    public function __construct()
    {
        $this->middleware('auth');

        $this->photo_path = 'storage/image/photo/';
        // echo $this->photo_path;
        // echo "<br>";
    }

    public function index(Request $request, Photo $photo, User $user)
    {
        // request_user
        $this->user_id = $request->user()->id;

        // 有加好友

        // 沒加好友
        // =========================
        // 取得相片
        $main_photo = $photo->orderBy('created_at','desc')->take(5)->get();

        // 取得相片資訊
        $main_photo->map(function($main_photo){
            $user_id = $main_photo['user_id'];
            $user_name = $main_photo->user_name;
            // echo $user_name;
            // exit;

            $main_photo['user_name'] = $user_name;
            return $main_photo;
        });
        // get_comment_num

        $photo_num = $main_photo->count();
        $last_photo_id = $main_photo->last()->id;

        // session
        $request->session()->put('last_photo_id', $last_photo_id);
        
        return view('main_page',[
            'main_photo'=>$main_photo,
            'photo_num'=>$photo_num,
            'last_photo_id'=>$last_photo_id,
            'photo_path'=>$this->photo_path,
        ]);
    }
    public function more_photo(Request $request, Photo $photo)
    {
        $last_photo_id = $request->session()->get('last_photo_id');

        // 有加好友

        // 沒加好友
        $more_photo = $photo->where('id','<',$last_photo_id)->orderBy('created_at','desc')->take(2)->get();
        $photo_num = $more_photo->count();

        // session
        $request->session()->put('last_photo_id',$more_photo->last()->id);
        
        return [
            'main'=>'more_photo load success!',
            'photo_num'=>$photo_num,
            'last_photo_id'=>$last_photo_id,
            'more_photo'=>$more_photo,
        ];
    }

}
