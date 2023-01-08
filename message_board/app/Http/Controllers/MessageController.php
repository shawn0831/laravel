<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateMessageRequest;
use App\user;
use App\Message;
use App\reply;
use Gate;
// 載入資源庫
use App\repositories\MessageRepository;

class MessageController extends Controller
{

    // 綁定中介層
    public function __construct(){
        $this->middleware('auth');
    }

    // ================================================================

    // index
    public function index(Request $request,MessageRepository $messageRepository){
        // 帶入視圖
        return view('message.index',[
            'all_messages'=>$messageRepository->forAllUser_desc(),
            'all_replys_count'=>$messageRepository->count_reply_for_messages(),
        ]);
    }

    // store
    public function store(Request $request){
        // 驗證(表單)請求內容
        $this->validate($request,[
            'message_content'=>'required|max:255',
        ]);

        // 建立留言
        $request->user()->messages()->create([
            'username'=>$request->username,
            'content'=>$request->message_content,
            'created_at'=>$request->time
        ]);

        return redirect('/message');
    }

    // destroy
    public function destroy(Request $request,Message $message){
        // 認證使用者是否有權刪除該留言
        $this->authorize('destroy_authorize',$message);

        // 刪除該實例
        $message->delete();

        return redirect('/message');
    }

    // ================================================================

    // reply_index
    public function reply_index(Request $request,MessageRepository $messageRepository,Message $message){
        // 帶入視圖
        return view('message.index',[
            'all_messages'=>$messageRepository->forAllUser_desc(),
            'all_replys_count'=>$messageRepository->count_reply_for_messages(),
            'replies'=>$messageRepository->forMessage_desc($message),
        ]);
    }
    // reply_store
    public function reply_store(Request $request,Message $message){
        // 驗證(表單)請求內容
        $this->validate($request,[
            'reply_content'=>'required|max:255',
        ]);

        // 建立留言
        $message->replys()->create([
            'user_id'=>$request->user_id,
            'username'=>$request->username,
            'content'=>$request->reply_content,
            'created_at'=>$request->time
        ]);

        return redirect("/message/$message->id");
    }

    // reply_destroy
    public function reply_destroy(Request $request,Message $message,Reply $reply){
        // 認證使用者是否有權刪除該留言
        // $this->authorize('reply_destroy_authorize',$reply);
        if($request->user()->id === $reply->user_id){
            // 刪除該實例
            $reply->delete();
        }

        return redirect("/message/$message->id");
    }

    // 調用授權邏輯-AuthServiceProvider
    // ================================================================
    // // ====================================
    // // 透過Gate調用授權邏輯
    // public function update_message_test1($id){
        
    //     $message = message::findOrFail($id);

    //     // Gate::denies(): 如果認證不通過，則返回true
    //     // Gate::allows(): 如果認證通過，則返回true
    //     // Gate::check(): 如果認證通過，則返回true，是allows的別名

    //     // 檢查當前使用者的權限
    //     if(Gate::denies('update-message',$message)){
    //         abort(403);
    //     }

    //     // 檢查其他使用者的權限
    //     if(Gate::forUser($user)->allows('update-message',$message)){
    //         // 
    //     }

    //     // 傳遞多個參數
    //     if(Gate::allows('delete-reply',[$message,$reply])){
    //         // 
    //     }
    // }

    // // ====================================
    // // 透過使用者模型調用授權邏輯
    // public function update_message_test2(Request $request,$id){

    //     $message = findOrFail($id);

    //     // $request->user()->can(): 如果認證通過，則返回true
    //     // $request->user()->cannot(): 如果認證不通過，則返回true

    //     if($request->user()->cannot('update_message',$message)){
    //         abort(403);
    //     }
    //     if($request->user()->can('update_message',$message)){
    //         // 
    //     }
    // }

    // // ====================================
    // // 引用 調用了授權邏輯的request
    // public function update_message_test3(UpdateMessageRequest $request,Message $message){
    //     echo '驗證成功';
    // }

    // 調用授權邏輯-policies
    // ================================================================
    // ====================================
    // 透過Gate調用授權邏輯
    public function update_message_test4($id){
        $message = Message::findOrFail($id);

         if(Gate::denies('update',$message)){
             abort(403);
         }
    }

    // ====================================
    // 透過使用者模型調用授權邏輯
    public function update_message_test5(User $user,$id){
        $message = Message::findOrFail($id);

        if($user->can('update',$message)){
            // 
        }
        if($user->cannot('update',$message)){
            // 
        }
    }

    // ====================================
    // 透過全域的policy輔助方法調用授權邏輯
    public function update_message_test6(Request $request,Message $message){

        $user = $request->user();

        if(policy($message)->update($user,$message)){
            echo '驗證成功';
        }else{
            abort(403);
        }

    }

    // ====================================
    // 透過controller類別包含的AuthorizesRequests trait內含的authorize方法調用授權邏輯
    public function update($id){
        $message = Message::findOrFail($id);

        $this->authorize('update',$message);
        // 如果授權通過將繼續程式，如果不通過則拋出例外

        // 為非當前認證的使用者授權行為
        $this->authorizeForUser($user,'update',$message);

        // 若控制器的方法與policy的方法名稱相同，則不需要policy函式名稱的參數，如下
        $this->authorize($message);
    }

}
