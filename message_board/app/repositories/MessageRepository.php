<?php
namespace App\repositories;
use App\User;
use App\Message;
use App\Reply;

class MessageRepository{
    public function forAllUser_desc(){
        return Message::orderBy('created_at','desc')->get();
    }

    public function count_reply_for_messages(){
        $messages = Message::orderBy('created_at','desc')->get();
        $all_replys_count=[];

        foreach($messages as $message){
            $replys = Reply::where('message_id',$message->id)->orderBy('created_at','desc')->get();
            $replys_count = count($replys);
            $all_replys_count[$message->id]=$replys_count;
        }

        return $all_replys_count;
    }

    public function forMessage_desc(Message $message){
        return Reply::where('message_id',$message->id)->orderBy('created_at','desc')->get();
    }
}
