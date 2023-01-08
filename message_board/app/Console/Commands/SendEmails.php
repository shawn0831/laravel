<?php

namespace App\Console\Commands;

use App\User;
// use App\DripEmailer;
use Illuminate\Console\Command;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // *參數及選項包含在大括號中

    // protected $signature = 'email:send {user}';
    // 定義參數為可選的(可有可無)
    // protected $signature = 'email:send {user?}';
    // 定義參數的預設值
    // protected $signature = 'email:send {user=foo}';

    // 定義選項(在前面加上--)
    // protected $signature = 'email:send {user}{--queue}}';
    // 定義選項為必填
    // protected $signature = 'email:send {user}{--queue=}';
    // 定義選項預設值
    // protected $signature = 'email:send {user}{--queue=default}';
    // 定預選項簡寫(在選項名稱前加入簡寫並用|符號隔開))
    // protected $signature = 'email:send {user}{--Q|queue}';
    // 定預參數或選項接收的值為陣列
    // protected $signature = 'email:send {user*}';
    // protected $signature = 'email:send {user}{--id=*}';
    // 為參數與選項加上敘述(在參數或選項名稱後面加上敘述，並用:隔開)
    protected $signature = 'email:send {user : 使用者的ID }{--queue= : 這個工作是否該進入隊列 }';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send drip emails to a user';

    protected $drip;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // $this->drip = $drip;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $this->drip->send(User::find($this->argument('user')));
        
        // 接收輸入
        // ====================================================
        // // 取得參數的輸入
        // $userId = $this->argument('user');
        // // echo $userId;
        // // 取得所有的參數
        // $arguments = $this->argument();
        // // print_r($arguments);

        // // 取得選項的輸入
        // $queueName = $this->option('queue');
        // // echo $queueName;
        // // 取得所有的選項
        // $options = $this->option();
        // // print_r($options);

        // // 要求輸入
        // $name = $this->ask('你的名子是?');
        // // echo '回答:'.$name;

        // // 要求密碼輸入
        // $password = $this->secret('密碼是?');
        // // echo '回答:'.$password;

        // // 確認(yes/no)
        // if($this->confirm('你希望繼續嗎?')){
        //     echo '繼續';
        // }

        // // 自動完成填值
        // $name = $this->anticipate('你的名子是?',['Taylor','Dayle'],'Taylor');
        // // echo $name;
        // // * 第三個參數為回傳的預設值

        // // 選擇已有的答案
        // $name = $this->choice('你的名子是?',['Taylor','Dayle'],'Dayle');
        // // echo $name;
        // // * 第三個參數為回傳的預設值

        // 輸出
        // ====================================================
        // // 輸出資訊訊息(綠色)
        // $this->info('把我顯示在畫面上');
        // // 輸出錯誤訊息(紅色)
        // $this->error('有東西出問題了!');
        // // 輸出訊息(沒有顏色)
        // $this->line('把我顯示在畫面上');
        // // 輸出註解訊息(黃色))
        // $this->comment('把我顯示在畫面上');
        // // 輸出問題訊息(藍色)
        // $this->question('把我顯示在畫面上');

        // // table
        // $headers = ['Name','Email'];
        // $users = User::all(['name','email'])->toArray();
        // $this->table($headers,$users);
        // // *第一個參數代表headers,第二個參數代表rows，第二個參數必須是二維陣列

        // // 進度條
        // $users = User::all();
        // $bar = $this->output->createProgressBar(count($users));
        // $bar->start();

        // foreach($users as $user){
        //     // $this->performTask($user);

        //     $bar->advance();
        // }
    
        // $bar->finish();

        // 呼叫其他指令
        // ====================================================
        // $this->call('email:send2',['user'=>1,'--queue'=>'default']);
        // 呼叫其他指令(忽視所有輸出)
        $this->callSilent('email:send2',['user'=>2,'--queue'=>'2']);

    }

}