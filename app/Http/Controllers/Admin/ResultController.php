<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Ques;
use App\User;
use DB;
use Auth;
use Mail;
use Validator;

class ResultController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *  回答情報のみを取得するメソッド
     * 
     * @return array
     */
    private function columns()
    {
        // TODO: モデルがあるのに使わないのはなんで？
        // TODO: 質問数変わったときに対処できない
        $stdArray = DB::table('ques')->select('q1','q2','q3','q4','q5','q6','q7','q8','q9','q10',
                                          'q11','q12','q13','q14','q15','q16','q17','q18','q19','q20',
                                          'q21','q22','q23','q24','q25','q26','free1','free2')->get();
        // TODO: encodeしたあとにdecodeしているのはなぜ？
        $data = json_decode(json_encode($stdArray), true);

        return $data;
    }

    /**
     *  少数点第一以下切り上げで中身のパーセンテージ計算メソッド
     * 
     * @return array
     */

    private function per($foo,$var)
    {
        foreach($foo as $key=>$val){
            $foo[$key] = round($val/$var*100,1);
        }

        return $foo;
    }

    /**
     *  アンケートの集計結果を表示するメソッド
     * 
     */

    public function result()
    {
        //回答総数算出
        $ques = DB::table('ques')->count();

        //回答がない場合、エラー画面に遷移
        // TODO: 空文字を直接比較するのではなくで, issetとか使いましょう. しかも、ゆるい一致なのでバグを生み出すかなと
        if($ques == ''){
            return view('admin.error');
        }

        // TODO: 回答総数算出を別でDBにアクセスしたの無駄と思う
        //カラム情報取得
        $data = $this->columns();

        //カラム情報をリスト化⇒中身の数を数える
        // TODO: ここもperメソッドのなかで実施すればよかったのでは・・・
        $qq1 = array_count_values(array_column($data,'q1'));
        $qq2 = array_count_values(array_column($data,'q2'));
        $qq3 = array_count_values(array_column($data,'q3'));
        $qq4 = array_count_values(array_column($data,'q4'));
        $qq5 = array_count_values(array_column($data,'q5'));
        $qq6 = array_count_values(array_column($data,'q6'));
        $qq7 = array_count_values(array_column($data,'q7'));
        $qq8 = array_count_values(array_column($data,'q8'));
        $qq9 = array_count_values(array_column($data,'q9'));
        $qq10 = array_count_values(array_column($data,'q10'));
        $qq11 = array_count_values(array_column($data,'q11'));
        $qq12 = array_count_values(array_column($data,'q12'));
        $qq13 = array_count_values(array_column($data,'q13'));
        $qq14 = array_count_values(array_column($data,'q14'));
        $qq15 = array_count_values(array_column($data,'q15'));
        $qq16 = array_count_values(array_column($data,'q16'));
        $qq17 = array_count_values(array_column($data,'q17'));
        $qq18 = array_count_values(array_column($data,'q18'));
        $qq19 = array_count_values(array_column($data,'q19'));
        $qq20 = array_count_values(array_column($data,'q20'));
        $qq21 = array_count_values(array_column($data,'q21'));
        $qq22 = array_count_values(array_column($data,'q22'));
        $qq23 = array_count_values(array_column($data,'q23'));
        $qq24 = array_count_values(array_column($data,'q24'));
        $qq25 = array_count_values(array_column($data,'q25'));
        $qq26 = array_count_values(array_column($data,'q26'));

        // TODO: 集計はDB側でやったほうがベターなので検討
        // TODO: $quesは$qq1の長さをcountすればいいのでは？
        //中身をパーセンテージ化
        $q1 = $this->per($qq1,$ques);
        $q2 = $this->per($qq2,$ques);
        $q3 = $this->per($qq3,$ques);
        $q4 = $this->per($qq4,$ques);
        $q5 = $this->per($qq5,$ques);
        $q6 = $this->per($qq6,$ques);
        $q7 = $this->per($qq7,$ques);
        $q8 = $this->per($qq8,$ques);
        $q9 = $this->per($qq9,$ques);
        $q10 = $this->per($qq10,$ques);
        $q11 = $this->per($qq11,$ques);
        $q12 = $this->per($qq12,$ques);
        $q13 = $this->per($qq13,$ques);
        $q14 = $this->per($qq14,$ques);
        $q15 = $this->per($qq15,$ques);
        $q16 = $this->per($qq16,$ques);
        $q17 = $this->per($qq17,$ques);
        $q18 = $this->per($qq18,$ques);
        $q19 = $this->per($qq19,$ques);
        $q20 = $this->per($qq20,$ques);
        $q21 = $this->per($qq21,$ques);
        $q22 = $this->per($qq22,$ques);
        $q23 = $this->per($qq23,$ques);
        $q24 = $this->per($qq24,$ques);
        $q25 = $this->per($qq25,$ques);
        $q26 = $this->per($qq26,$ques);

        // TODO: viewにわたす変数多すぎるので、まとめる
        return view ('admin.result',compact('ques','q1','q2','q3','q4','q5','q6','q7','q8','q9','q10','q11','q12','q13','q14','q15','q16',
                                            'q17','q18','q19','q20','q21','q22','q23','q24','q25','q26'));
    }

}