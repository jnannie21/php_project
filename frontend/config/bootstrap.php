<?php

//function func(){
//    echo $var123;
//}
//
//$var123 = 667;
//func($var123, 'jdsklf');
//die;


//function func($qwe){
////    $ui = $qwe[0].'::'.$qwe[1];
////    $ui();
//    $qwe[0] -> {$qwe[1]}();
//}
//
//class cl {
//    function func2(){
//        echo 13;
//    }
//}
//
//
//$as = 12;
//
//$f = function () use($as){
//    echo $as;
//};
//
////$f();
//
//$kk = new cl();
////$kk -> func2();
//
//func([$kk, 'func2']);
//
//die;



//class cl {
//    static function func(){
//        echo '123';
//    }
//}
//
//$vaar = 'cl';
//cl::func();
//$vaar::func();
//die;

//$dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
//$stmt = $dbh->prepare ("INSERT INTO user (firstname, surname) VALUES (:f-name, :s-name)");

//use yii\helpers\HtmlPurifier;
//
//$new = htmlspecialchars('<a href"test">Test</a>', ENT_QUOTES);
//echo $new.'<br>'; // &lt;a href=&#039;test&#039;&gt;Test&lt;/a&gt;
////echo HtmlPurifier::process('<a href"test">Test</a>');
//die;
//try {
//    throw new Exception('ppp');
//}
//catch (Except $e) {
//    echo $e->getMessage();
//}
//catch (Exception $e) {
//    echo '13';
//}
//
//die;
//$er = 12;

//if (true){
//    echo $er;
//}
//die;

//$er = new Redis();
//$er->connect('127.0.0.1', 6379);
//$er->sAdd('mdif:ss', 15);
//var_dump($er->sMembers('mdif:ss'));
//die;

//$arr[0] = 0;
//$arr[1] = 1;
//$arr[6] = 6;
//$arr[2] = 2;
//
//foreach ($arr as $el){
//    echo $el.'<br>';
//}
//
//die;

//class t {
//public $qq = 789;
//}
//
//$r = new t();
//echo $r->qq;
//die;

//$var1 = 12;
//$var2 = 23;
//$var3 = $var1 || $var2;
//echo $var3;
//die;

//phpinfo();
//die;

//function f() {echo 777; return 123;}
//function ff() {echo 666; return 234;}
//
//$var = f() || ff();
//
////$var = $var ?: 123;
//
//echo $var;
//
//die;


//function yy($var = []){
//    echo 666;
//}
//
//yy();
//
//die;

//$str = '006';
//
//$var = $str + 123;
//
//echo $var;
//
//die;


//function behaviors() {
//
//    return [
//        'goback' => [
//            'class' => GoBackFilter::class,
//            'actions' => ['signup', 'login', 'logout', 'request-password-reset'],
//        ],
//    ];
//}

//$arr['qwe'] = null;
//$we = false;
//if (empty($we)) {
//    echo 666;
//}
//die;


//$url = parse_url(null, PHP_URL_HOST);
//
//var_dump($url);
//
//die;

//function gg(){
//    echo 111;
//    return 111;
//}
//function ee(){
//    echo 222;
////    return 222;
//}
//function tt(){
//    return ee() or gg();
//}
//
//true and gg() and ee();
//
////echo $dd;
//
//die;




//$id = $session->getHasSessionId() || $session->getIsActive() ? $session->get($this->idParam) : null;


//$var = 12;
//
//$arr = [];
//if ($var == $arr['qwe']){
//    echo $var;
//}
//die;

//class Model {
//
//    static function ttt(){
//        return 'gg';
//    }
//    
//    public function ggg() {
//        return 333;
//    }
//
//}
//
//class User extends Model {
//
//    public function ggg() {
//        return 444;
//    }
//}
//
//class my extends User {
//    static $nn = 999;
//    
//    public function ggg() {
//        return 555;
//    }
//    
//    public function myfunc(){
//        echo Model::ggg().'<br>';
//        echo User::ggg().'<br>';
//        echo static::ggg().'<br>';
//        echo static::$nn.'<br>';
//        echo $this->ttt().'<br>';
//    }
//}
//
//$var = new my();
//
//$var->myfunc();
//
//die;







////echo User::ggg().'<br>';
//$user = new User();
//echo $user->ggg().'<br>';
////echo $user::getlable();
//die;



//function qwe(){
//    echo '666'.'<br>';
//    return true;
//}
//
//if(true || qwe()){
//    echo 'good'; die;
//}
//echo 'no good';
//die;



//function t1(){
//    echo 123;
//}
//
//class rt{
//    static $one = 666+666;
//    public $tt = 987;
//}
//
// 
//$obj = new rt();
//call_user_func('t1', $obj);
////echo t1($obj);
////echo rt::$one;
//
//die;




//echo 'jdkf \n "dfdf"';
//
//die;
//false && var_dump("fjkals");
//die;
//include "1.php";
//echo $var;
//
//die;
//namespace tt\gg;
//
//class Yy {
//
//    public function Uu() {
//        $Var = 666;
//        echo $Var;
//    }
//
//}
//
//$var = new YY();
//$var->uu();
//die;




//use yii\base\Security;
//
//$security = new Security();
//$token1 = "tlkTgoOtV9C";
//$token2 = "tlkTgoOtV9C";
//
//
//$t1 = $security->maskToken($token1);
//$t2 = $security->maskToken($token2);
//echo $t1."<br/>".$t2."<br/>";
//
//$token1 = $security->unmaskToken($t1);
//$token2 = $security->unmaskToken($t2);
//
//echo $token1."<br/>".$token2."<br/>";
//die;