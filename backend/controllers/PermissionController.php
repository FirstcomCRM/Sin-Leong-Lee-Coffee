<?php

namespace backend\controllers;

use Yii;
use backend\models\Permission;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use backend\models\PermissionSearch;
use \yii\helpers\Url;
use yii\filters\AccessControl;




/**
 * PermissionController implements the CRUD actions for Permission model.
 */
class PermissionController extends Controller
{
    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        if(Yii::$app->user->isGuest){
            return [

                ' access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['login', 'error'],
                            'allow' => true,
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ];
            
        }else{

            return [

                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ];
        }
    }

    /**
     * Lists all Permission models.
     * @return mixed
     */
    public function actionIndex()
    {
        $permission = new PermissionSearch();
        $role = Yii::$app->user->identity->user_role;
    
        $controller = str_replace('-','',Yii::$app->controller->id);
        $fName = Yii::$app->controller->action->id;
        $controller = $permission->list_view($role,$controller,$fName);
        if(count($controller) == 0){
            throw new ForbiddenHttpException('You have no access in this page');
        }

        $data['list'] = $permission->list_view();

        return $this->render('index', $data);
      //   return $this->render('index');
    }

    /**
     * Displays a single Permission model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $permission = new PermissionSearch();
        $role = Yii::$app->user->identity->user_role;
        $controller = str_replace('-','',Yii::$app->controller->id);
        $fName = Yii::$app->controller->action->id;
        $controller = $permission->list_view($role,$controller,$fName);
        if(count($controller) == 0){
            throw new ForbiddenHttpException('You have no access in this page');
        }

        $permission = Permission::find()->where(['role_id' => $id])->all();

        return $this->render('view', [
            'permission' => $permission,
        ]);
    }

    /**
     * Creates a new Permission model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {

        $permission = new PermissionSearch();
        $role = Yii::$app->user->identity->user_role;
        $controller = str_replace('-','',Yii::$app->controller->id);
        $fName = Yii::$app->controller->action->id;
        $controller = $permission->list_view($role,$controller,$fName);
        if(count($controller) == 0){
            throw new ForbiddenHttpException('You have no access in this page');
        }

        if(Yii::$app->request->post()){/*
            echo Yii::$app->request->post('role');
        die();*/
            /*print_r(Yii::$app->request->post('permission'));
                die();*/
            if(count(Yii::$app->request->post('permission')) == null){
                
                Yii::$app->getSession()->setFlash('error', 'Please Select Permission');
                return $this->redirect(['permission/create']);

            }else{
                $array = array();

                foreach (Yii::$app->request->post('permission') as $key => $value) {
                    $value2 = explode('-', $value);
                    $array[] = $value2[0];
                }
                $controller_role = array_unique($array);


                $listController = array();
                $nameController = "";

                foreach ($controller_role as $key => $value) {
                    //echo $value.'<br>';
                    $listController[$value] = array();
                    $nameController = $value;
                    foreach (Yii::$app->request->post('permission') as $new_key => $new_value) {
                        
                        $new_value2 = explode('-', $new_value);
                        if($nameController == $new_value2[0]){

                            array_push($listController[$new_value2[0]], $new_value2[1]);
                        }
                    }
                }

                foreach ($listController as $key => $value) {
                    $model = new Permission();
                    $model->role_id = Yii::$app->request->post('role');
                    $model->controller = $key;
                    $model->permission = implode(",", $value);;
                    $model->save();
                }

                Yii::$app->getSession()->setFlash('success', 'Successfully added');
                return $this->redirect(['permission/index']);
            }

            
            
        }else{

            $fulllist = $this->Getcontroller();

            $model = new Permission();
            $model2 = new PermissionSearch();
            $user = $model2->list_view();

                return $this->render('create', [
                    'model' => $model,
                    'fulllist' => $fulllist,
                    'user' => $user,

                ]);
        }
    }

    /**
     * Updates an existing Permission model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $permission = new PermissionSearch();
        $role = Yii::$app->user->identity->user_role;
        $controller = str_replace('-','',Yii::$app->controller->id);
        $fName = Yii::$app->controller->action->id;
        $controller = $permission->list_view($role,$controller,$fName);
        if(count($controller) == 0){
            throw new ForbiddenHttpException('You have no access in this page');
        }

        if(Yii::$app->request->post()){

            if(count(Yii::$app->request->post('permission')) == null){
                
                Yii::$app->getSession()->setFlash('error', 'Please Select Permission');
                return $this->redirect(['permission/create']);

            }else{
                Permission::deleteAll('role_id = '.$id);

                $array = array();

                foreach (Yii::$app->request->post('permission') as $key => $value) {
                    $value2 = explode('-', $value);
                    $array[] = $value2[0];
                }
                $controller_role = array_unique($array);


                $listController = array();
                $nameController = "";

                foreach ($controller_role as $key => $value) {
                    //echo $value.'<br>';
                    $listController[$value] = array();
                    $nameController = $value;
                    foreach (Yii::$app->request->post('permission') as $new_key => $new_value) {
                        
                        $new_value2 = explode('-', $new_value);
                        if($nameController == $new_value2[0]){

                            array_push($listController[$new_value2[0]], $new_value2[1]);
                        }
                    }
                }

                foreach ($listController as $key => $value) {
                    $model = new Permission();
                    $model->role_id = Yii::$app->request->post('role');
                    $model->controller = $key;
                    $model->permission = implode(",", $value);;
                    $model->save();
                }

                Yii::$app->getSession()->setFlash('success', 'Successfully updated');
                return $this->redirect(['permission/index']);
            }

            
            
        }else{
            $fulllist = $this->Getcontroller();
            $model2 = new PermissionSearch();
            $user = $model2->list_update($id);

                return $this->render('update', [
                    
                    'fulllist' => $fulllist,
                    'user' => $user,
                    
                    ]);
        }
    }

    public function Getcontroller()
    {

        $controllerlist = [];
        if ($handle = opendir('../controllers')) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != ".." && substr($file, strrpos($file, '.') - 10) == 'Controller.php') {
                    $controllerlist[] = $file;
                }
            }
            closedir($handle);
        }
        asort($controllerlist);
        $fulllist = [];
        foreach ($controllerlist as $controller):
            $handle = fopen('../controllers/' . $controller, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    if (preg_match('/public function action(.*?)\(/', $line, $display)):
                        if (strlen($display[1]) > 2):
                            $fulllist[substr($controller, 0, -4)][] = strtolower($display[1]);
                        endif;
                    endif;
                }
            }
            fclose($handle);
        endforeach;
        /*echo '<pre>';
        print_r($fulllist);
        echo '</pre>';*/
        return $fulllist;
    } 

    /**
     * Deletes an existing Permission model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $permission = new PermissionSearch();
        $role = Yii::$app->user->identity->user_role;
        $controller = str_replace('-','',Yii::$app->controller->id);
        $fName = Yii::$app->controller->action->id;
        $controller = $permission->list_view($role,$controller,$fName);
        if(count($controller) == 0){
            throw new ForbiddenHttpException('You have no access in this page');
        }

        Permission::deleteAll('role_id = '.$id);
        
        Yii::$app->getSession()->setFlash('success', 'Delete Successfully');
        
        return $this->redirect(['index']);
    }

    /**
     * Finds the Permission model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Permission the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Permission::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    
}
