<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UserRole;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use backend\models\PermissionSearch;
use \yii\helpers\Url;
use yii\filters\AccessControl;


/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
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
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            

        ]);
    }

    /**
     * Displays a single User model.
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
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

        $model = new User();
        $user = UserRole::find()->all();


        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);
            $model->auth_key = Yii::$app->security->generateRandomString();
            $model->created_at = time();
            $model->updated_at = time();

            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
            
        } else {
            return $this->render('create', [
                'model' => $model,
                'user'=> $user
            ]);
        }
    }

    /**
     * Updates an existing User model.
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

        $model = $this->findModel($id);
        $user = UserRole::find()->all();

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);
            $model->updated_at = time();
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
            
        } else {
            return $this->render('update', [
                'model' => $model,
                'user'=> $user,
            ]);
        }

    }

    /**
     * Deletes an existing User model.
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
        
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
