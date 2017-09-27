<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Boiler */

$this->title = 'Create Boiler';
$this->params['breadcrumbs'][] = ['label' => 'Boilers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="boiler-create">

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
		    <?= $this->render('_form', [
		        'model' => $model,
		        'customer' => $customer,
            'model_sum'=>$model_sum,
		    ]) ?>
		</div>
	</div>

</div>
