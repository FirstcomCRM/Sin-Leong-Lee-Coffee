<?php

namespace backend\controllers;

use Yii;
use backend\models\UserRole;
use backend\models\UserRoleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use backend\models\PermissionSearch;
use yii\filters\AccessControl;

/**
 * UserRoleController implements the CRUD actions for UserRole model.
 */
class UserRoleController extends Controller
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
     * Lists all UserRole models.
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

        $searchModel = new UserRoleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserRole model.
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
     * Creates a new UserRole model.
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

        $model = new UserRole();

        if ( Yii::$app->request->post()) {   

            //$model->role = Yii::$app->request->post('role');
            $model->date_created = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->id;
           
            if($model->load(Yii::$app->request->post()) && $model->save()) {
                
                return $this->redirect(['view', 'id' => $model->id]);

            }else{
                return $this->render('create', [
                'model' => $model,
                ]);
            }

        }else{
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing UserRole model.
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UserRole model.
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
     * Finds the UserRole model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserRole the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserRole::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
