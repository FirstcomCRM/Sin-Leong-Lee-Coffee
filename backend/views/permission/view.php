<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Permission */

$this->title = 'View';
$this->params['breadcrumbs'][] = ['label' => 'Permissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

/*echo '<pre>';
print_r($permission);
echo '</pre>';*/
?>

<div class="permission-view">

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">

            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="myTable">
                    <?php
                    foreach ($permission as $key => $value) {
                        echo '<tr>';
                        echo '<td>'.$value['controller'].'</td>';
                        echo '<td>'.str_replace(",",", ",$value['permission']).'</td>';
                        echo '</tr>';
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>

</div>
