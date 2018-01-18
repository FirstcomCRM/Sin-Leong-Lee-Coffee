<?php

use yii\helpers\ArrayHelper;
use backend\models\AccountList;
use backend\models\ExpensesReport;

$transact =AccountList::find()->select('transaction_group')->where(['transaction_type'=>'Expense'])
          ->andWhere(['<>','transaction_group',''])
          ->distinct()->orderBy(['transaction_group'=>SORT_ASC])->asArray()->all();


 ?>
 <style>
   .headers{
     text-align: center;
   }
 </style>

 <?php $account_codes = AccountList::find()->asArray()->all(); ?>


 <div class="container-fluid">

    <div class="row">
   <?php foreach ($transact as $key => $value): ?>

       <div class="col-md-6">

         <table class="table table-bordered">
             <thead>
               <th colspan=2 class="headers"><?php echo $value['transaction_group'] ?></th>
             </thead>
             <tbody>
               <tr>
                 <?php $account_codes = AccountList::find()->where(['transaction_group'=>$value])->orderBy(['account_details'=>SORT_ASC])->asArray()->all(); ?>


                 <?php foreach ($account_codes as $key => $value_a): ?>
                   <?php $sums = ExpensesReport::find()->where(['id_code'=>$value_a['account']])
                           ->andWhere(['between','date_uploaded',$date_from,$date_to])
                           ->sum('debit'); ?>
                    <?php $transact_sum[] = $sums ?>
                    <td><?php echo $value_a['account'].' - '.$value_a['account_details'] ?></td>
                    <td><?php echo $sums==0? '$0.00': '$'.number_format($sums,2) ?></td>
               </tr>

               <?php endforeach; ?>
               <tr>
                 <td><strong>Total</strong> </td>
                 <td><strong><?php echo '$'.number_format(array_sum($transact_sum),2) ?></strong> </td>
               </tr>
             </tbody>
           </table>
       </div>


   <?php endforeach; ?>
   </div>
 </div>
