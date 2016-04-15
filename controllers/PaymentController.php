<?php

class PaymentController extends Controller
{
	new changes , add changes to payment
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	
	public function actions()
        {
            return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
            'class'=>'CCaptchaAction',
            'backColor'=>0xFFFFFF,
            ),
            
            'page'=>array(
            'class'=>'CViewAction',
            ),
            );
        }
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','index','view','delete'),
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionIndex()
	{
		$session = Yii::app()->session;
		$prefixLen = strlen(CCaptchaAction::SESSION_VAR_PREFIX);
		
		if(!Yii::app()->user->isGuest){
			$this->layout='//layouts/column2';
				
		}else{
				$this->layout='//layouts/column1';

		}
		$model=new Payment;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Payment']))
		{
			$model->attributes=$_POST['Payment'];
			if($model->save()){
				foreach($session->keys as $key)
				{
					if(strncmp(CCaptchaAction::SESSION_VAR_PREFIX, $key, $prefixLen) == 0)
						$session->remove($key);
				}
				if($model->TypeOrder=='P'){
					$this->redirect(array('/order/view2','oid'=>md5(intval($model->IdOrder))));
					//$this->redirect(array('/order/index'));
				}
			}
			
		}
		foreach($session->keys as $key)
		{
			if(strncmp(CCaptchaAction::SESSION_VAR_PREFIX, $key, $prefixLen) == 0)
				$session->remove($key);
		}
		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='payment-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
