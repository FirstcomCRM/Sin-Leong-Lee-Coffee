<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\AccountList;
use yii\Helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\AccountListSearch */
/* @var $form yii\widgets\ActiveForm */

$data = AccountList::find()->all();
$list = ArrayHelper::map($data,'account','account');
?>

<div class="account-list-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?= $form->field($model, 'account') ->dropDownList($list)?>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Reset',['index'],['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
