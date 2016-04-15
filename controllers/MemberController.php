<?php

//namespace app\controllers;
namespace app\controllers;
name space;;

use Yii;
use yii\helpers\Url;
use yii\web\View;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\EntryForm;
use app\models\LoginForm;



class MemberController extends Controller
{
    //public $layout= main;
    public function actionIndex() {
	    return $this->render('index'); //seharusnya seperti index.php
    
    }
    
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        
        $model->load(Yii::$app->request->post());
        //print_r( $model->email );
        //
        //die();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            
            //echo 'success login';
            //echo 'id = '.Yii::$app->user->Id;
            //die();
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    
   

}

?>