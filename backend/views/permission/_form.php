<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\Permission */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="permission-form">


    <?php $form = ActiveForm::begin(); ?>   
    <?php

    ?>
    <select name="role" class="col-md-3 btn btn-default" id="year" required>
        <option value="">Select Role</option>
        <?php 
            if(isset($_GET['id'])){
            ?>
              <option value='<?php echo $user[0]['id'];?>' selected="selected"><?php echo ucfirst($user[0]['role']);?></option>
        <?php   
            }else{
                foreach ($user as $key => $value) {
                    if($value['controller'] == "" && $value['permission'] == ""){
                        ?>
                            <option value='<?php echo $value['id'];?>'><?php echo ucfirst($value['user_role']);?></option>
                        <?php
                    }
                }
            }    
        ?>
    </select>
    <br>
    <br>
    <?php
        foreach ($fulllist as $key => $value) {
            preg_match('/(.*)Controller/', $key, $display);
            if($display[1] != 'Site'){
            
    ?>

                <div class="col-md-3"><input type="checkbox" onchange="checkAll('<?= $display[1]; ?>')" id="<?= $display[1]; ?>" name="controller[]" value="<?= $display[1]; ?>"><strong><?= $display[1]; ?></strong><ul style="list-style: none;">
        <?php
                foreach ($value as $value2) {
        ?>
                    <li><input type="checkbox" onchange="checkSub('<?= $display[1]; ?>')" class="<?= $display[1]; ?>" name="permission[]" value="<?= $display[1].'-'.$value2; ?>"><?= $value2; ?></li>
        <?php
                }
                echo '</ul></div>';
            }
        }
    ?>
    

    

    
    <div class="form-group col-md-12">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<script type="text/javascript">

 function checkAll(name = null) {

    if($('#'+name).prop("checked")) {
        $('.'+name).prop("checked", true);
    } else {
        $('.'+name).prop("checked", false);
    }                
}

function checkSub(name = null){

    if($('.'+name).length == $('.'+name+":checked").length) {
        $('#'+name).prop("checked", true);
    }else {
        $('#'+name).prop("checked", false);            
    }
        

 }

</script>