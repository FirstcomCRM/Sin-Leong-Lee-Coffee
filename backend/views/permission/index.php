<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PermissionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Permissions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-index">

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a('Create Permission', ['create'], ['class' => 'btn btn-success']) ?>
            </p>


            <?php

            $list_role = array();
            foreach ($list as $key => $value) {
                $list_role[] = $value['user_role'].'-'.$value['role_id'];
            }

            $list_role2 = array_unique($list_role);

            $arrayList = array();
            $nameRole = "";
            foreach ($list_role2 as $key2 => $value2) {
                $arrayList[$value2] = array();
                $nameRole = $value2;
                foreach ($list as $key => $value) {
                    
                    if($nameRole == $value['user_role'].'-'.$value['role_id']){

                        array_push($arrayList[$value['user_role'].'-'.$value['role_id']], $value['controller']);
                    }
                }
            }

            ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="myTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Role</th>
                            <th>Permission</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $number = 1;
                        foreach ($arrayList as $key => $value) {
                            $role = explode('-', $key);
                            if($role[1] != null){
                    ?>
                        <tr>
                            <td><?= $number?></td>
                            <td><?= $role[0]; ?></td>
                            <td><?= implode(", ",$value); ?></td>
                            <td><?php echo Html::a('<span class="glyphicon glyphicon-eye-open"></span>', array('permission/view', 'id'=>$role[1])); ?> 
                            <?php echo Html::a('<span class="glyphicon glyphicon-pencil"></span>', array('permission/update', 'id'=>$role[1])); ?>
                            <?php echo Html::a('<span class="glyphicon glyphicon-trash"></span>', ['permission/delete', 'id'=>$role[1]], [
                                'data' => [
                                    'confirm' => "Are you sure you want to delete?",
                                    'method' => 'post',
                                ],
                            ]);?>
                                
                            </td>
                        </tr>

                    <?php
                            }
                        $number++;
                        }

                    ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
