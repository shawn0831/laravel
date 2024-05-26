<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;
use App\Comment;
use Illuminate\Support\Facades\Storage;

class ManageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // storage
        $this->photo_path = 'image\\\photo\\\\';
        $this->tmp_photo_path = 'image\\\tmp_photo\\\\';
        // echo $this->photo_path;
        // echo "<br>";
    }

    public function index(Request $request, Photo $photo)
    {
        $this->user_id = $request->user()->id;

        $all_photo = $photo->where('user_id', $this->user_id)->orderBy('created_at','desc')->get();
        $photo_num = $all_photo->count();

        return view('manage.manage_photo',[
            'all_photo'=>$all_photo,
            'photo_path'=>$this->photo_path,
            'photo_num'=>$photo_num,
        ]);
    }
    // upload_photo
    // =========================================
    public function upload_photo_preview(Request $request, Photo $photo){
        if($request->hasFile('upload_photo')){
            $file = $request->file('upload_photo');
            $valid = $file->isValid();
            $file_name = time().'_'.$file->getClientOriginalName();
            $file_extension = $file->extension();
            $file_size = $file->getSize();
            
            // storage
            $tmp_file = $file->storeAs($this->tmp_photo_path, $file_name);
            
            return ['photo'=>'upload_photo preview success!',
                'valid'=>$valid,
                'file_name'=>$file_name,
                'file_extension'=>$file_extension,
                'file_path'=>$tmp_file,
                'file_size'=>$file_size,
                'public_path'=>$tmp_file,
            ];
        }else{
            return ['photo'=>'upload_photo preview failed!'];
        }
    }
    public function release_photo(Request $request, photo $photo){
        $user = $request->user();
        $user_id = $user->id;
        $user_name = $user->name;

        $tmp_photo_name = $request->tmp_photo_name;

        $tmp_path = $this->tmp_photo_path . $tmp_photo_name;
        $path = $this->photo_path . $tmp_photo_name;

        // 建立photo
        $this->validate($request,[
            'tmp_photo_name'=>'required|max:255',
            'write_photo_name'=>'required|max:255',
            'write_introduction'=>'max:255',
        ]);

        // 移動暫存檔
        Storage::move($tmp_path, $path);
        Storage::deleteDirectory($this->tmp_photo_path);

        // 手動移動暫存檔
        // rename(public_path('storage/image/tmp_photo/'.$tmp_photo_name), public_path('storage/image/photo/'.$tmp_photo_name));

        $user->photos()->create([
            'photo_name'=>$request->write_photo_name,
            'file_name'=>$request->tmp_photo_name,
            'introduction'=>$request->write_introduction,
            'creater'=>$user_id,
            'updater'=>$user_id,
        ]);

        return ['photo'=>'release photo success!',
            'tmp_path'=>$tmp_path,
            'path'=>$path,
        ];
    }

    // manage_photo
    // =========================================
    // all_photo
    public function all_photo(Request $request, Photo $photo){
        $user_id = $request->user()->id;
    
        $all_photo = $photo->where('user_id', $user_id)->orderBy('created_at','desc')->get();
        $photo_num = $all_photo->count();
        $data = [$all_photo,$photo_num];
        return $data;
    }
    // single_photo
    public function single(Request $request, Photo $photo){
        return $photo;
    }

    // manage
    public function delete_photo(Request $request, Photo $photo){
        $file_name = $photo->file_name;

        $this->authorize('photo_authorize', $photo);
        $photo->delete();

        $delete_path = $this->photo_path . $file_name;
        Storage::delete($delete_path);

        // 手動刪除相片
        // unlink(public_path('storage/image/photo/'.$file_name));

        return ['photo'=>'delete success!'];
    }
    public function update_photo_preview(Request $request){
        if($request->hasFile('update_photo')){
            $file = $request->file('update_photo');
            $valid = $file->isValid();
            $file_name = time().'_'.$file->getClientOriginalName();
            $file_extension = $file->extension();
            $file_size = $file->getSize();

            // storage
            $tmp_file = $file->storeAs($this->tmp_photo_path,$file_name);

            // 手動複製檔案
            // copy(storage_path('app/public/image/tmp_photo/'.$file_name), public_path('storage/image/tmp_photo/'.$file_name));
            
            return ['photo'=>'update_photo preview success!',
                'valid'=>$valid,
                'file_name'=>$file_name,
                'file_extension'=>$file_extension,
                'file_path'=>$tmp_file,
                'file_size'=>$file_size,
            ];
        }else{
            return ['photo'=>'update_photo preview failed!'];
        }
    }
    public function update_photo_submit(Request $request, photo $photo){
        $user = $request->user();
        $user_id = $user->id;
        $user_name = $user->name;

        $tmp_photo_name = $request->tmp_photo_name;
        $photo_name = $request->photo_name;

        $tmp_path = $this->tmp_photo_path.$tmp_photo_name;
        $path = $this->photo_path.$tmp_photo_name;
        $delete_path = $this->photo_path.$photo_name;

        // 更改 Photo 檔案名稱
        $this->authorize('photo_authorize', $photo);
        
        $this->validate($request,[
            'tmp_photo_name'=>'required|max:255',
            ]);
            
        // 移動暫存檔
        Storage::move($tmp_path, $path);
        Storage::delete($delete_path);
        Storage::deleteDirectory($this->tmp_photo_path);

        // 手動移動暫存檔
        // rename(public_path('storage/image/tmp_photo/'.$tmp_photo_name), public_path('storage/image/photo/'.$tmp_photo_name));
        // unlink(public_path('storage/image/photo/'.$photo_name));

        $photo->update([
            'file_name'=>$tmp_photo_name,
            'updater'=>$user_name,
        ]);

        return ['photo'=>'update_photo submit success!',
            'tmp_path'=>$tmp_path,
            'path'=>$path,
            'delete_path'=>$delete_path,
        ];
    }
    public function update_introduction(Request $request, Photo $photo){
        $user = $request->user();
        $user_id = $user->id;
        $user_name = $user->name;

        $this->authorize('photo_authorize', $photo);

        // 驗證(表單)請求內容
        $this->validate($request,[
            'update_photo_name'=>'required|max:255',
            'update_introduction'=>'max:255',
        ]);

        $photo->update([
            'photo_name'=>$request->update_photo_name,
            'introduction'=>$request->update_introduction,
            'updater'=>$user_id,
        ]);

        return ['photo'=>'update introduction success!'];
    }

}
