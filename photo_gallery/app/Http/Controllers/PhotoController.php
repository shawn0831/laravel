<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;
use App\Comment;

class PhotoController extends Controller
{
    public $user_id;
    public $photo_path;

    public function __construct()
    {
        $this->middleware('auth');

        $this->photo_path = 'image\\\photo\\';
        // echo $this->photo_path;
        // echo "<br>";
    }

    // all_photo
    public function index(Request $request, Photo $photo)
    {
        $this->user_id = $request->user()->id;

        $all_photo = $photo->where('user_id', $this->user_id)->orderBy('created_at','desc')->get();
        $photo_num = $all_photo->count();

        return view('photo.all_photo',[
            'all_photo'=>$all_photo,
            'photo_path'=>$this->photo_path,
            'photo_num'=>$photo_num,
        ]);     
    }
    // single_photo
    public function single(Request $request, Photo $photo){
        return $photo;
    }

    // comment
    public function comment(Request $request, Photo $photo, Comment $comment){
        $photo_id = $photo->id;
    
        $all_comment = $comment->select('comments.*', 'users.name')
            ->leftJoin('users', 'comments.user_id', '=', 'users.id')
            ->where('photo_id', $photo_id)
            ->orderBy('comments.created_at','desc')
            ->get();
        $comment_num = $all_comment->count();
        $data = [$all_comment,$comment_num];
        return $data;
    }
    public function write_comment(Request $request, Photo $photo, Comment $comment){
        $user = $request->user();
        $user_id = $user->id;
        $user_name = $user->name;
        $photo_id = $photo->id;

        // 驗證(表單)請求內容
        $this->validate($request,[
            'comment'=>'required|max:255',
        ]);

        $photo->comments()->create([
            'user_id'=>$user_id,
            'photo_id'=>$photo_id,
            'comment'=>$request->comment,
            'creater'=>$user_id,
            'updater'=>$user_id,
        ]);

        return ['comment'=>'create success!'];
    }
    function delete_comment(Request $request, Comment $comment){
        $user = $request->user();
        $user_id = $user->id;

        $this->authorize('comment_authorize', $comment);
        $comment->delete([
            'updater'=>$user_id,
        ]);

        return ['comment'=>'delete success!'];
    }
    function update_comment(Request $request, Comment $comment){
        $user = $request->user();
        $user_id = $user->id;
        $user_name = $user->name;

        $this->authorize('comment_authorize', $comment);

        // 驗證(表單)請求內容
        $this->validate($request,[
            'comment_update'=>'required|max:255',
        ]);

        $comment->update([
            'comment'=>$request->comment_update,
            'updater'=>$user_id,
        ]);

        return ['comment'=>'update success!'];
    }

}
