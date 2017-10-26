<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Boiler */

$this->title = 'Create Boiler';
$this->params['breadcrumbs'][] = ['label' => 'Boilers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="boiler-create">

		 <?= $this->render('_form', [
		      'model' => $model,
		      'customer' => $customer,
          'model_sum'=>$model_sum,
					'model_line'=>$model_line,
    ]) ?>


</div>
