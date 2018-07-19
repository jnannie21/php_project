<?php

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