<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Expenses */

$this->title = 'View';
$this->params['breadcrumbs'][] = ['label' => 'Expenses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expenses-view">

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="myTable">
                    <thead>
                        <tr>
                            <th>ID#</th>
                            <th>Src</th>
                            <th>Date</th>
                            <th>Memo</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Job No.</th>
                            <th>Net Activity</th>
                            <th>Ending Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            
                            if (count($list) == 0 ):
                                echo 'No Data Available';
                            else:
                                foreach($list as $value):
                                    if(($value['id_no'] == null) && ($value['scr'] == null) && ($value['date'] == null) && ($value['memo'] == null) && ($value['debit'] == null) && ($value['credit'] == null) && ($value['net_activity'] == null) && ($value['ending_balance'] == null)):
                                    else:
                        ?>
                                        <tr>
                                            <td><?= $value['id_no']; ?></td>
                                            <td><?= $value['scr']; ?></td>
                                            <td><?= $value['date']; ?></td>
                                            <td><?= $value['memo']; ?></td>
                                            <?php
                                                if($value['debit'] != null){
                                                    echo '<td>$'.number_format(floatval($value['debit']),2).'</td>';
                                                }else{
                                                    echo '<td>'.$value['debit'].'</td>';
                                                }
                                            ?>
                                            <?php
                                                if($value['credit'] != null){
                                                    echo '<td>$'.number_format(floatval($value['credit']),2).'</td>';
                                                }else{
                                                    echo '<td>'.$value['credit'].'</td>';
                                                }
                                            ?>
                                            <td><?= $value['job_no']; ?></td>
                                            <?php
                                                if($value['net_activity'] != null){
                                                    echo '<td>$'.number_format(floatval($value['net_activity']),2).'</td>';
                                                }else{
                                                    echo '<td>'.$value['net_activity'].'</td>';
                                                }
                                            ?>
                                            <?php
                                                if($value['ending_balance'] != null){
                                                    echo '<td>$'.number_format(floatval($value['ending_balance']),2).'</td>';
                                                }else{
                                                    echo '<td>'.$value['ending_balance'].'</td>';
                                                }
                                            ?>
                                        </tr>
                        <?php 
                                    endif;
                                
                                endforeach;
                            endif;
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>



</div>
