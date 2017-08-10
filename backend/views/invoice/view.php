<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Invoice */

$this->title = 'View';
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="invoice-view">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="myTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Invoice No</th>
                            <th>Date</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Average Cost</th>
                            <th>Job No</th>
                            <th>Sales Person</th>
                            <th>Customer Card Id</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $itemCode = "";
                        $sum = 0;
                        $number = 1;
                        //echo count($name);
                        if (count($name) == 0 ):
                        echo 'No Data Available';
                        else:
                            foreach($name as $value): 
                                if($itemCode == ""){
                                    $itemCode = $value['invoice_item_code'];
                                }
                                
                                if($itemCode != $value['invoice_item_code']){
                                    ?>
                                    <tr>

                                        
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><strong>Total:</strong></td>
                                        <td><?= '$'.number_format($sum,2); ?></td>  
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    
                                    <?php
                                    $itemCode = "";
                                    $sum = 0;
                                }
                                $sum += $value['amount'];
                        ?>

                            <tr>
                                <th scope="row"><?= $number; ?></th>
                                <td><?= $value['customer_name']; ?></td>
                                <td><?= $value['invoice_no']; ?></td>
                                <td><?= $value['date']; ?></td>
                                <td><?= $value['quantity']; ?></td>
                                <td><?= '$'.number_format($value['amount'],2); ?></td>
                                <td><?= $value['average_cost']; ?></td>
                                <td><?= $value['job_no']; ?></td>
                                <td><?= $value['sales_person']; ?></td>
                                <td><?= $value['customer_card_id']; ?></td>
                            </tr>
                            <?php  $number++;
                            endforeach;
                            ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><strong>Total:</strong></td>
                                    <td><?= '$'.number_format($sum,2); ?></td>  
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php 
                        endif;
                            ?>
                       
                    </tbody>
                </table>
            </div>
        </div>
    </div>  
</div>

