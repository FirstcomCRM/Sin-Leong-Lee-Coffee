<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Permission */

$this->title = 'Create Permission';
$this->params['breadcrumbs'][] = ['label' => 'Permissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-create">

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">

		    <?= $this->render('_form', [
		        'model' => $model,
		        'fulllist' => $fulllist,
		        'user' => $user,
		    ]) ?>
		</div>
	</div>

</div>
