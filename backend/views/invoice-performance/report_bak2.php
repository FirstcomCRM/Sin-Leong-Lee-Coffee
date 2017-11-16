<?php

use yii\helpers\ArrayHelper;
use backend\models\InvoicePerformance;
use backend\models\Expenses;
use backend\models\ExpensesReport;
use backend\models\AssetType;
use backend\models\AccountList;
use backend\models\RebateReport;

$total_expenses = 0;
$total_cost = 0;
$sum_cost = 0;

$all = InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])->sum('amount');
$all_cost =  InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])->all();

foreach ($all_cost as $key => $value) {
  $cost = $value->quantity * $value->average_cost;
  $sum_cost += $cost;
}

$aProfit = $all-$sum_cost;
$hide = 0; //edr temporaril;y hide the boiler, asset types


$excel_expense = Expenses::find()->where(['between','month',$date_from,$date_to])->sum('total');
$rebate_list = AccountList::find()->where(['transaction_type'=>'Rebate'])->all();

 ?>

<style>

  td{
    border: none;
  }

  .cust_name{
    font-weight: bold;
  }
  .sub-title{
    padding-left: 2em;
  }
  .td-left{
    width: 40%;
    border: none;
  }
  .sub-name{
    padding-left: 4em;
  }
  .total{
    font-weight: bold;
    font-size: 20px;
  }
</style>

<div class="container">

<p class="cust-name"><h1 style="text-align: center;font-weight:bold;">Sin Leong Lee Coffee Ptd</h1></p>
<p class="cust-name"><h2 style="text-align: center;font-weight:bold;"><?php echo $searchModel->customer_name ?></h2> </p>
<p><strong><?php echo date('m/d/Y') ?></strong> </p>
<p><strong><?php echo date("h:i:sa") ?></strong> </p>

<!---Regarding the formula in the excel file
total sales amount = amount * quantity
total cost amount = avg cost * quanty
--->
<hr style="border-color:black;height:1px">
<!--Income Table-->
<table class="table income-table" >
<tr>
  <td colspan = "2">Income</td>
</tr>
<tr>
  <td colspan = "2"><span class="sub-title">Sales</span></td>
</tr>
<tr>
  <td class="td-left" > <span class="sub-name"></span>Sales Coffee</td>
  <td>
    <?php $sCoffee = InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])
          ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
          ->andFilterWhere(['item_abbr'=>'C'])
          ->sum('amount');
          if ($sCoffee ==null) {
            echo '$'.number_format(0,2);
          }else{
            echo '$'.number_format($sCoffee,2);
          }

    ?>
  </td>
</tr>
<tr>
  <td class="td-left"><span class="sub-name">Sales Tea</td>
  <td>
    <?php $sTea = InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])
          ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
          ->andFilterWhere(['item_abbr'=>'T'])
          ->sum('amount');
          if ($sTea ==null) {
            echo '$'.number_format(0,2);
          }else{
            echo '$'.number_format($sTea,2);
          }
    ?>
  </td>
</tr>
<tr>
  <td class="td-left"><span class="sub-name">Sales Mug</td>
  <td>
    <?php $sMug = InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])
          ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
          ->andFilterWhere(['item_abbr'=>'M'])
          ->sum('amount');
          if ($sMug ==null) {
            echo '$'.number_format(0,2);
          }else{
            echo '$'.number_format($sMug,2);
          }

    ?>
  </td>
</tr>
<tr>
  <td class="td-left"><span class="sub-name">Sales Others</td>
  <td>
    <?php $sOther = InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])
          ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
          ->andFilterWhere(['!=','item_abbr','C'])
          ->sum('amount');
          if ($sOther ==null) {
            echo '$'.number_format(0,2);
          }else{
            echo '$'.number_format($sOther,2);
          }
          ?>
  </td>
</tr>

<tr><!--Rebate and Discount row-->
  <td class="td-left"><span class="sub-title">Rebates & Discount</td>
</tr>
<?php foreach ($rebate_list as $value): ?>
  <?php
    $rebate_reports = RebateReport::find()->where(['account'=>$value->account])
                    ->andWhere(['customer'=>$searchModel->customer_name])
                    ->one();
   ?>

     <tr>
       <td class="td-left"><span class="sub-name"><?php echo $value->account.' '.$value->account_details ?></span></td>
       <td>
         <?php
            $rebate_sum =  RebateReport::find()->where(['account'=>$value->account])
                      ->andWhere(['customer'=>$searchModel->customer_name])
                      ->andWhere(['between','date',$date_from,$date_to])
                      ->sum('amount');
            //echo '($'.abs(number_format($rebate_sum,2)).')';
            $rebate_sum = abs($rebate_sum);
            echo '($'.number_format($rebate_sum,2). ')'
          ?>
       </td>
     </tr>

<?php endforeach; ?>

<tr>
  <td class="td-left"><span class="sub-title total">Total Rebate and Discount</td>
  <td>
    <span class="total">
      <?php
         $rebate_sum =  RebateReport::find() ->where(['customer'=>$searchModel->customer_name])
                   ->andWhere(['between','date',$date_from,$date_to])
                   ->sum('amount');
         //echo '($'.abs(number_format($rebate_sum,2)).')';
         $rebate_sum = abs($rebate_sum);
         echo '($'.number_format($rebate_sum,2). ')'
       ?>
    </span>
  </td>
</tr>


<tr>
  <td class="td-left"><span class="sub-title total">Total Income</td>
  <td>
    <span class="total">
      <?php $sTotal = InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])
            ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
            //->andFilterWhere(['!=','item_abbr','M'])
            ->sum('amount');
            $nTotal = $sTotal - $rebate_sum;
          //  echo '$'.number_format($sTotal,2);
            echo '$'.number_format($nTotal,2);
          ?>
    </span>
  </td>
</tr>

</table>

<br>
<!--Cost of Sales Table-->
<table class="table cost-table">
<tr>
  <td colspan = "2">Cost of Sales</td>
</tr>
<tr>
  <td colspan = "2"><span class="sub-title">Cost of Sales</span></td>
</tr>
<tr>
  <td class="td-left"> <span class="sub-name"></span>Cost of Goods Coffee</td>
  <td>
    <?php
    $cCoffee = InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])
          ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
          ->andFilterWhere(['item_abbr'=>'C'])
          ->all();
    foreach ($cCoffee as $key => $value) {
      $avg_cof = $value->quantity * $value->average_cost;
      $total_cost += $avg_cof;
    }
    echo '$'.number_format($total_cost,2);
    $total_cost = 0;
    ?>
  </td>
</tr>
<tr>
  <td class="td-left"><span class="sub-name">Cost of Goods Tea</td>
  <td>
    <?php $cTea = InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])
          ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
          ->andFilterWhere(['item_abbr'=>'T'])
          ->all();
          foreach ($cTea as $key => $value) {
            $avg_cof = $value->quantity * $value->average_cost;
            $total_cost += $avg_cof;
          }
          echo '$'.number_format($total_cost,2);
          $total_cost = 0;
    ?>
  </td>
</tr>
<tr>
  <td class="td-left"><span class="sub-name">Cost of Goods Mug</td>
  <td>
    <?php $cMug = InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])
          ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
          ->andFilterWhere(['item_abbr'=>'M'])
          ->all();
          foreach ($cMug as $key => $value) {
            $avg_cof = $value->quantity * $value->average_cost;
            $total_cost += $avg_cof;
          }
          echo '$'.number_format($total_cost,2);
          $total_cost = 0;
    ?>
  </td>
</tr>
<tr>
  <td class="td-left"><span class="sub-name">Cost of Goods Others</td>
  <td>
    <?php $cOther = InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])
          ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
          ->andFilterWhere(['!=','item_abbr','C'])
          ->all();
          foreach ($cOther as $key => $value) {
            $avg_cof = $value->quantity * $value->average_cost;
            $total_cost += $avg_cof;
          }
          echo '$'.number_format($total_cost,2);
          $total_cost = 0;
          ?>
  </td>
</tr>
<tr>
  <td class="td-left"><span class="sub-title total">Total Cost of Sales</td>
  <td>
    <span class="total">
      <?php $cTotal = InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])
            ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
            ->all();
            foreach ($cTotal as $key => $value) {
              $avg_cof = $value->quantity * $value->average_cost;
              $total_cost += $avg_cof;
            }
            echo '$'.number_format($total_cost,2);

      ?>
      </span>
  </td>
</tr>
</table>


<br>
<!--Cost of Gross Profit Table-->
<table class="table gross-table">

<tr>
  <td class="td-left"><span class="total">Customer Gross Profit</span></td><!--Customer gross  profit for months in between--->
  <td>
    <span class="total">
      <?php
      $gProfit = $sTotal - $total_cost;
      echo '$'.number_format($gProfit,2);
      ?>
    </span>
  </td>
</tr>


<br>
<!--All Gross Profit Table-->
<table class="table gross-table">
  <tr>
    <td class="td-left"><span class="total">Total All Sales Amount</span></td>
    <td><span class="total"><?php echo '$'.number_format($all,2) ?></span></td>
  </tr>
  <tr>
    <td class="td-left"><span class="total">Total All Cost Amount</span></td>
    <td><span class="total"><?php echo '$'.number_format($sum_cost,2) ?></span></td>
  </tr>
<tr>
  <td class="td-left"><span class="total">Total All Gross Profit</span></td><!--all gross  profit for months in between--->
  <td>
    <span class="total">
      <?php
  //    $allProfit = $gProfit - $aProfit;
      echo '$'.number_format($aProfit,2);
      ?>
    </span>
  </td>
</tr>


<br>
<!--Cost of Expenses Table-->
<table class="table expense-table">
  <tr>
    <td colspan = "2">Expense</td>
  </tr>
  <tr>
    <td class="td-left" colspan="2"><span class="sub-title">Expense</span></td>
  </tr>
  <tr>
    <td class="td-left"><span class="sub-name">Share Expenses Amount</span></td>
    <td>
      <?php
        $expense = $gProfit/$aProfit;
        $shared_expense = $excel_expense * $expense;
        echo '$'.number_format($shared_expense,2);
      ?>
    </td>
  </tr>

  <tr>
    <td class="td-left"><span class="sub-title">Administrative Costs</span></td> <!--start of administrative cost---->
  </tr>
  <?php
  $data = AccountList::find()->where(['transaction_group'=>'Administrative Costs'])->all();
   ?>
  <?php foreach ($data as $key => $value): ?>
    <tr>
      <td class="td-left"><span class="sub-name"><?php echo $value->account.' '.$value->account_details ?></span></td>
      <td>
        <?php $cost = ExpensesReport::find()->where(['id_code'=>$value->account])
              ->andWhere(['between','date_uploaded',$date_from,$date_to])
              ->sum('debit');
            echo '$'.number_format($cost,2);
        ?>
      </td>
    </tr>
  <?php endforeach; ?><!--end of administrative cost---->

  <tr>
      <td class="td-left"><span class="sub-title">Fixed Asset Costs</span></td> <!--start of fixed asset cost---->
  </tr>
  <?php
  $data = AccountList::find()->where(['transaction_group'=>'Fixed Asset Costs'])->all();
   ?>
  <?php foreach ($data as $key => $value): ?>
    <tr>
      <td class="td-left"><span class="sub-name"><?php echo $value->account.' '.$value->account_details ?></span></td>
      <td>
        <?php $cost = ExpensesReport::find()->where(['id_code'=>$value->account])
              ->andWhere(['between','date_uploaded',$date_from,$date_to])
              ->sum('debit');
            echo '$'.number_format($cost,2);
        ?>
      </td>
    </tr>
  <?php endforeach; ?><!--end of fixed asset cost---->

  <tr>
      <td class="td-left"><span class="sub-title">Utilities Costs</span></td> <!--start of Utilities Costs---->
  </tr>
  <?php
  $data = AccountList::find()->where(['transaction_group'=>'Utilities Costs'])->all();
   ?>
  <?php foreach ($data as $key => $value): ?>
    <tr>
      <td class="td-left"><span class="sub-name"><?php echo $value->account.' '.$value->account_details ?></span></td>
      <td>
        <?php $cost = ExpensesReport::find()->where(['id_code'=>$value->account])
              ->andWhere(['between','date_uploaded',$date_from,$date_to])
              ->sum('debit');
            echo '$'.number_format($cost,2);
        ?>
      </td>
    </tr>
  <?php endforeach; ?><!--end of Utilities Costs---->

  <tr>
      <td class="td-left"><span class="sub-title">Employment Costs</span></td> <!--start of Employment Costs---->
  </tr>
  <?php
  $data = AccountList::find()->where(['transaction_group'=>'Employment Costs'])->all();
   ?>
  <?php foreach ($data as $key => $value): ?>
    <tr>
      <td class="td-left"><span class="sub-name"><?php echo $value->account.' '.$value->account_details ?></span></td>
      <td>
        <?php $cost = ExpensesReport::find()->where(['id_code'=>$value->account])
              ->andWhere(['between','date_uploaded',$date_from,$date_to])
              ->sum('debit');
            echo '$'.number_format($cost,2);
        ?>
      </td>
    </tr>
  <?php endforeach; ?><!--end of Employment Costs---->

  <tr>
      <td class="td-left"><span class="sub-title">Marketing Costs</span></td> <!--start of Marketing Costs---->
  </tr>
  <?php
  $data = AccountList::find()->where(['transaction_group'=>'Marketing Costs'])->all();
   ?>
  <?php foreach ($data as $key => $value): ?>
    <tr>
      <td class="td-left"><span class="sub-name"><?php echo $value->account.' '.$value->account_details ?></span></td>
      <td>
        <?php $cost = ExpensesReport::find()->where(['id_code'=>$value->account])
              ->andWhere(['between','date_uploaded',$date_from,$date_to])
              ->sum('debit');
            echo '$'.number_format($cost,2);
        ?>
      </td>
    </tr>
  <?php endforeach; ?><!--end of Marketing Costs---->

  <tr>
      <td class="td-left"><span class="sub-title">Customer Expenses</span></td> <!--start of Customer Expenses---->
  </tr>
  <?php
  $data = AccountList::find()->where(['transaction_group'=>'Customer Expenses'])->all();
   ?>
  <?php foreach ($data as $key => $value): ?>
    <tr>
      <td class="td-left"><span class="sub-name"><?php echo $value->account.' '.$value->account_details ?></span></td>
      <td>
        <?php $cost = ExpensesReport::find()->where(['id_code'=>$value->account])
              ->andWhere(['between','date_uploaded',$date_from,$date_to])
              ->sum('debit');
            echo '$'.number_format($cost,2);
        ?>
      </td>
    </tr>
  <?php endforeach; ?><!--end of Customer Expenses---->

  <tr>
      <td class="td-left"><span class="sub-title">Factory Maintenance Costs</span></td> <!--start of Factory Maintenance Costs---->
  </tr>
  <?php
  $data = AccountList::find()->where(['transaction_group'=>'Factory Maintenance Costs'])->all();
   ?>
  <?php foreach ($data as $key => $value): ?>
    <tr>
      <td class="td-left"><span class="sub-name"><?php echo $value->account.' '.$value->account_details ?></span></td>
      <td>
        <?php $cost = ExpensesReport::find()->where(['id_code'=>$value->account])
              ->andWhere(['between','date_uploaded',$date_from,$date_to])
              ->sum('debit');
            echo '$'.number_format($cost,2);
        ?>
      </td>
    </tr>
  <?php endforeach; ?><!--end of Factory Maintenance Costs---->

  <tr>
      <td class="td-left"><span class="sub-title">Motor Vehicle Costs</span></td> <!--start of Motor Vehicle Costs---->
  </tr>
  <?php
  $data = AccountList::find()->where(['transaction_group'=>'Motor Vehicle Costs'])->all();
   ?>
  <?php foreach ($data as $key => $value): ?>
    <tr>
      <td class="td-left"><span class="sub-name"><?php echo $value->account.' '.$value->account_details ?></span></td>
      <td>
        <?php $cost = ExpensesReport::find()->where(['id_code'=>$value->account])
              ->andWhere(['between','date_uploaded',$date_from,$date_to])
              ->sum('debit');
            echo '$'.number_format($cost,2);
        ?>
      </td>
    </tr>
  <?php endforeach; ?><!--end of Motor Vehicle Costs---->

<tr>
  <td class="td-left"><span class="sub-title total">Total Expenses</span></td>
  <td>
    <span class="total">
      <?php
        $excel_expense = number_format($excel_expense,2);
        echo '$'.$excel_expense;
       ?>
      <?php// edr echo  '$'.number_format($total_expenses,2)?>
    </span>
  </td>
</tr>
</table>


<br>
<!--Cost of Gross Profit Table-->
<table class="table net-table">
<tr>
  <td class="td-left"><span class="total">Net Profit</span></td>
  <td>
    <span class="total">
      <?php $nProfit = $gProfit - $total_expenses;
        if ($nProfit<0) {
          $x = abs($nProfit);
          echo '($'.number_format($x,2).')';
        }else{
          echo '$'.number_format($nProfit,2);
        }

      ?>
    </span>
  </td>
</tr>
<!---<tr>
  <td class="td-left"><span class="total">Invidivual Percentage</span></td>
  <td>
    <span class="total">
      <?php

        $ind = ($gProfit/($all-$sum_cost))*100;

        echo number_format($ind,3).'%';
      ?>
    </span>
  </td>
</tr>--->
<tr>
  <td class="td-left"><span class="total">Shared Expense Percentage</span></td>
  <td>
    <span class="total">
      <?php

        //$ind = ($gProfit/($all-$sum_cost))*100;
        $expense = $expense *100;
        echo number_format($expense,3).'%';
      ?>
    </span>
  </td>
</tr>
</table>

</div>
