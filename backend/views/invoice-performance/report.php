<?php

use yii\helpers\ArrayHelper;
use backend\models\InvoicePerformance;
use backend\models\Expenses;
use backend\models\ExpensesReport;
use backend\models\AssetType;
use backend\models\AccountList;
use backend\models\RebateReport;
use backend\models\DirectExpense;
use backend\models\BoilerLine;


$total_expenses = 0;
$total_cost = 0;
$total_income = 0;
$income_coffee = 0;
$income_tea = 0;
$sum_cost = 0;
$ind_total = 0;
$ind_name  = 0;
$ind_exp = '';
$ind_summation =[];
$individual_customer_expense = 0;
$rebate_coffee_summation = [];
$rebate_tea_summation = 0;
$total_shared = 0;
$gross_coffee = 0;
$gross_tea = 0;
$gross_all = 0;
$non_invoice= 0;
$non_invoice_amount = [];
$boiler = 0;
$month_interval = 0;
$cost_gp = 0;
$kg = 95742;
$net_profit = 0;
$logic = null;
$shared = 0;
$shared_expenses_total = [];
$shared_expense = 0;
$gp_leong = 0;

if ($searchModel->type_l == 'Coffee') {
  $logic = true;
}else{
  $logic = false;
}

$excel_expense = Expenses::find()->where(['between','month',$date_from,$date_to])->sum('total');
$rebate_list = AccountList::find()->where(['transaction_type'=>'Rebate'])->orderBy(['account'=>SORT_ASC])->asArray()->all();
$all = InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])->sum('amount');
$all_cost =  InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])->all();
$all_rebates = RebateReport::find()->andFilterWhere(['between', 'date', $date_from,$date_to])->sum('amount');


foreach ($all_cost as $key => $value) {
  $cost = $value->quantity * $value->average_cost;
  $sum_cost += $cost;
}
//$aProfit = $all-($sum_cost+abs($all_rebates));


if ($searchModel->type_l == 'Coffee') {
  $sales_codes = ['4-1110','0','4-1130','4-1140'];
  $cost_codes = ['5-1110','0','5-1130','5-1140'];
  unset($rebate_list[1]);
}elseif($searchModel->type_l == 'Tea') {
  $sales_codes = ['0','4-1120','4-1130','4-1140'];
  $cost_codes = ['0','5-1120','5-1130','5-1140'];
  unset($rebate_list[0]);
}else{
  $sales_codes = ['4-1110','4-1120','4-1130','4-1140'];
  $cost_codes = ['5-1110','5-1120','5-1130','5-1140'];
}


//$sales_codes = ['4-1110','4-1120','4-1130','4-1140'];//Item code for sales coffee, sales tea, sales mug and spoon and sales others
//$cost_codes = ['5-1110','5-1120','5-1130','5-1140'];//Item code for cost of goods coffee, cost of goods tea, cost of goods mug and spoon and cost of goods others
//$cost_codes = ['5-1110','5-1120','5-1130','5-1140','5-1150','5-1160','5-1170'];
//Sum of sales income based on the sales code. [0]=sales coffee, [1]=sales tea, [2]=sales mug and spoon, [3]= sales others
$sales_income = [];
foreach ($sales_codes as  $value) {
  $sales_income[] =  InvoicePerformance::find()->joinWith(['codes'])->andFilterwhere(['between', 'date', $date_from,$date_to])
                    ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
                    ->andFilterWhere(['item_list.income'=>$value ])
                    ->sum('amount');
}

//Sum of cost of goods based on the cost_code.  [0]=cost of goods coffee, [1]=cost of goods tea, [2]=cost of goods mug and spoon, [3]= cost of goods others
$cost_goods = [];
$avg_cost = 0;
$cost_total = 0;
foreach ($cost_codes as $value) {
      $costs  = InvoicePerformance::find()->joinWith(['codes'])->andFilterwhere(['between', 'date', $date_from,$date_to])
                   ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
                   ->andFilterWhere(['item_list.exp_cos'=>$value ])
                   ->asArray()
                   ->all();
      foreach ($costs as $key => $value) {
         $avg_cost = $value['quantity'] * $value['average_cost'];
         $cost_total += $avg_cost;
      }
      $cost_goods[] =$cost_total;
      $avg_cost = 0;
      $cost_total = 0;
}



//get the incomve vs cost of goods
$gProfit = array_sum($sales_income) - array_sum($cost_goods);

//Invidiual expenses area
$ind = InvoicePerformance::find()->select(['item_name'])->distinct()
       ->andFilterWhere(['between', 'date', $date_from,$date_to])
      ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
      ->andFilterWhere(['amount'=>0])
      ->asArray()
      ->orderBy(['item_name'=>SORT_ASC])
      ->all();

//extrat all Asset Type list that is used on the dropdown of expense type in Direct Expense
$asset = AssetType::find()->asArray()->orderBy(['asset'=>SORT_ASC])->all();

//extract the sum of depreciate expense in boiler.
$boiler = BoilerLine::find()->where(['customer_name'=>$searchModel->customer_name])
              ->andFilterWhere(['between','date_from',$date_from,$date_to])
              ->sum('dep_amount');

//extract all shared expenses
$transact =AccountList::find()->select('transaction_group')->where(['<>','transaction_group',''])->distinct()->asArray()->all();

//$total_shared = array_sum($admin_cost)+array_sum($fixed_cost)+array_sum($util_cost)+array_sum($employ_cost)+array_sum($market_cost)+array_sum($custom_cost)+array_sum($fact_cost)+array_sum($motor_cost);

$month_from = $searchModel->month_from;
$year_from = $searchModel->year_from;
$month_to = $searchModel->month_to;
$year_to = $searchModel->year_to;
$merge_from = $month_from.' '.$year_from;
$merge_to = $month_to.' '.$year_to;

$date1 = date_create($merge_from);
$date2 = date_create($merge_to);
$interval = date_diff($date1, $date2);
$month_interval = $interval->m+($interval->y * 12)+1;


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
  .sub-title-a{
    font-weight: bold;
  }
  .td-left{
    width: 40%;
    border: none;
  }
  .td-remain{
    width: 20%;
  }
  .sub-name{
    padding-left: 4em;
  }
  .total{
    font-weight: bold;
    font-size: 20px;
  }
  .column-head{
    font-weight: bold;
    text-decoration: underline;
  }
  .t-headers{
    color:blue;
  }
</style>

<div class="container-fluid">


<p class="cust-name"><h1 style="text-align: center;font-weight:bold;"><?php echo $searchModel->customer_name ?></h1></p>

<?php if ($merge_from == $merge_to): ?>
  <p class="cust-name"><h3 style="text-align: center;font-weight:bold;"><?php echo $month_from.' '.$year_from ?></h3></p>
<?php else: ?>
  <p class="cust-name"><h3 style="text-align: center;font-weight:bold;"><?php echo $merge_from.' - '.$merge_to ?></h3></p>
<?php endif; ?>


<!---
total sales: <?php echo $all ?>
<br>
total rebates: <?php echo $all_rebates ?>
<br>
total income(total sales - total rebates): <?php echo $all + $all_rebates ?>
<br>
total cost of sales: <?php echo $sum_cost ?>
<br>
Gross profit all:
<?php

$gp_leong = ($all+$all_rebates)-$sum_cost;
echo $gp_leong ?>
<br>
shared percentage all:<?php $test ?>

--->
<br>
<hr style="border-color:black;height:1px">

  <table class="table table-bordered">
    <thead>
      <th></th>
      <th></th>
      <th class="t-headers"> Amount </th>
      <th class="t-headers"> Average per mth </th>
      <th class="t-headers">% by ALL GP</th>
      <th class="t-headers">% by Coffee GP</th>
      <th class="t-headers"> Amount by 9kg </th>
    </thead>
    <tr>
      <td colspan = "2"><span class="column-head"> Income</span></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
        <td></td>
        <td colspan = "1"><span><strong>Sales</strong></span></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <?php if ($searchModel->type_l == 'Coffee'): ?>
      <tr>
        <td></td>
        <td>Sales Coffee (95,742 tin/ctn)</td>
        <td><?php echo $sales_income[0]==0?'-':number_format($sales_income[0],2)  ?></td>
        <td>
          <?php echo $sales_income[0]/$month_interval==0?'-':number_format($sales_income[0]/$month_interval,2)  ?>
        </td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    <?php elseif($searchModel->type_l == 'Tea' ): ?>
      <tr>
        <td></td>
        <td>Sales Tea</td>
        <td><?php echo $sales_income[1]==0?'-':number_format($sales_income[1],2)  ?>  </td>
        <td>
          <?php echo $sales_income[1]/$month_interval==0?'-':number_format($sales_income[1]/$month_interval,2)  ?>
        </td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    <?php else: ?>
      <tr>
        <td></td>
        <td>Sales Coffee (95,742 tin/ctn)</td>
        <td><?php echo $sales_income[0]==0?'-':number_format($sales_income[0],2)  ?></td>
        <td>
          <?php echo $sales_income[0]/$month_interval==0?'-':number_format($sales_income[0]/$month_interval,2)  ?>
        </td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td>Sales Tea</td>
        <td><?php echo $sales_income[1]==0?'-':number_format($sales_income[1],2)  ?>  </td>
        <td>
          <?php echo $sales_income[1]/$month_interval==0?'-':number_format($sales_income[1]/$month_interval,2)  ?>
        </td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
      </tr>
    <?php endif; ?>
    <tr>
      <td></td>
      <td>Sales Mugs & Spoons</td>
      <td><?php echo $sales_income[2]==0?'-':number_format($sales_income[2],2)  ?></td>
      <td>
        <?php echo $sales_income[2]/$month_interval==0?'-':number_format($sales_income[2]/$month_interval,2)  ?>
      </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td>Sales Others</td>
      <td><?php echo $sales_income[3]==0?'-':number_format($sales_income[3],2)  ?></td>
      <td>
        <?php echo $sales_income[3]/$month_interval==0?'-':number_format($sales_income[3]/$month_interval,2)  ?>
      </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr><!--empty space between datas-->
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr><!--empty space between datas-->
    <tr>
        <td></td>
        <td colspan = "1"><span><strong>Rebates & Discount</strong></span></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>

    <!--Execute Rebate loop herer-->
    <?php foreach ($rebate_list as $value): ?>
    <?php
       $rebate_sum =  RebateReport::find()->where(['account'=>$value['account']])
                 ->andWhere(['customer'=>$searchModel->customer_name])
                 ->andWhere(['between','date',$date_from,$date_to])
                 ->sum('amount');
       $rebate_sum = abs($rebate_sum);
       if ($value['account']=='4-2102') { //acccount code tea
         $rebate_tea_summation = $rebate_sum;
       }else{
        $rebate_coffee_summation[] =$rebate_sum;
       }

    ?>
      <tr>
        <td></td>
        <td><?php echo $value['account_details'] ?></td>
        <td><?php echo $rebate_sum == 0 ? '-':'('.number_format($rebate_sum,2). ')'; ?></td>
        <td>
          <?php echo $rebate_sum/$month_interval==0? '-':'('.number_format($rebate_sum/$month_interval,2). ')' ?>
        </td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    <?php endforeach; ?>

    <!--Execute Rebate loop herer-->
    <tr>
    <tr><!--empty space between datas-->
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr><!--empty space between datas-->
      <td></td>
      <td colspan = "1"><span><strong>Income</strong></span></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <?php if ($searchModel->type_l == 'Coffee'): ?>
      <tr>
        <td></td>
        <td> Sales Coffee   (95,742 tin/ctn) </td>
        <td>
          <?php $income_coffee = $sales_income[0]- array_sum($rebate_coffee_summation) ?>
            <?php echo number_format($income_coffee,2) ?>
        </td>
        <td>
          <?php echo $income_coffee/$month_interval==0?'-':number_format($income_coffee/$month_interval,2) ?>
        </td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    <?php elseif($searchModel->type_l == 'Tea'): ?>
      <tr>
        <td></td>
        <td>  Sales Tea (19,053 tin) </td>
        <td>
          <?php $income_tea = $sales_income[1]- $rebate_tea_summation ?>
          <?php echo number_format($income_tea,2) ?>
        </td>
        <td>
          <?php echo $income_tea/$month_interval==0?'-':number_format($income_tea/$month_interval,2) ?>
        </td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    <?php else: ?>
      <tr>
        <td></td>
        <td> Sales Coffee   (95,742 tin/ctn) </td>
        <td>
          <?php $income_coffee = $sales_income[0]- array_sum($rebate_coffee_summation) ?>
            <?php echo number_format($income_coffee,2) ?>
        </td>
        <td>
          <?php echo $income_coffee/$month_interval==0?'-':number_format($income_coffee/$month_interval,2) ?>
        </td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td>  Sales Tea (19,053 tin) </td>
        <td>
          <?php $income_tea = $sales_income[1]- $rebate_tea_summation ?>
          <?php echo number_format($income_tea,2) ?>
        </td>
        <td>
          <?php echo $income_tea/$month_interval==0?'-':number_format($income_tea/$month_interval,2) ?>
        </td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    <?php endif; ?>
    <tr>
      <td></td>
      <td> Income - Mugs & Spoons </td>
      <td><?php echo $sales_income[2]==0?'-':number_format($sales_income[2],2)  ?></td>
      <td>
        <?php echo $sales_income[2]/$month_interval==0?'-':number_format($sales_income[2]/$month_interval,2)  ?>
      </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td> Income - Others  </td>
      <td><?php echo $sales_income[3]==0?'-':number_format($sales_income[3],2)  ?></td>
      <td>
        <?php echo $sales_income[3]/$month_interval==0?'-':number_format($sales_income[3]/$month_interval,2)  ?>
      </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td><strong> Total Income </strong> </td>
      <td>
        <?php $total_income = $income_coffee+$income_tea+$sales_income[2]+$sales_income[3] ?>
        <strong><?php echo number_format($total_income,2) ?></strong>
      </td>
      <td>
        <strong><?php echo $total_income/$month_interval==0? '-':number_format($total_income/$month_interval,2) ?></strong>
      </td>
      <td><strong>100.00%</strong> </td>
      <td></td>
      <td></td>
    </tr>
    <tr><!--empty space between datas-->
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr><!--empty space between datas-->
    <tr>
      <td colspan = "2"><span class="column-head">Cost of Sales</span></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td colspan = "1"><span><strong>Cost of Sales</strong> </span></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <?php if ($searchModel->type_l == 'Coffee'): ?>
      <tr>
        <td></td>
        <td>Cost of Goods Coffee</td>
        <td><?php echo number_format($cost_goods[0],2) ?></td>
        <td>
            <?php echo $cost_goods[0]/$month_interval==0?'-':number_format($cost_goods[0]/$month_interval,2)  ?>
        </td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    <?php elseif($searchModel->type_l == 'Tea'): ?>
      <tr>
        <td></td>
        <td>Cost of Goods Tea</td>
        <td><?php echo number_format($cost_goods[1],2) ?></td>
        <td>
          <?php echo $cost_goods[1]/$month_interval==0?'-':number_format($cost_goods[1]/$month_interval,2)  ?>
        </td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    <?php else: ?>
      <tr>
        <td></td>
        <td>Cost of Goods Coffee</td>
        <td><?php echo number_format($cost_goods[0],2) ?></td>
        <td>
            <?php echo $cost_goods[0]/$month_interval==0?'-':number_format($cost_goods[0]/$month_interval,2)  ?>
        </td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td>Cost of Goods Tea</td>
        <td><?php echo number_format($cost_goods[1],2) ?></td>
        <td>
          <?php echo $cost_goods[1]/$month_interval==0?'-':number_format($cost_goods[1]/$month_interval,2)  ?>
        </td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    <?php endif; ?>
    <tr>
      <td></td>
      <td>Cost of Goods Mug</td>
      <td>
        <?php echo $cost_goods[2]==0?'-':number_format($cost_goods[2],2) ?>
      </td>
      <td>
        <?php echo $cost_goods[2]/$month_interval==0?'-':number_format($cost_goods[2]/$month_interval,2)  ?>
      </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td>Cost of Goods Others</td>
      <td>
          <?php echo $cost_goods[3]==0?'-':number_format($cost_goods[3],2) ?>
      </td>
      <td>
        <?php echo $cost_goods[3]/$month_interval==0?'-':number_format($cost_goods[3]/$month_interval,2)  ?>
      </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td><strong> Total Cost of Sales </strong> </td>
      <td><strong><?php echo number_format(array_sum($cost_goods),2) ?></strong> </td>
      <td>
        <?php echo array_sum($cost_goods)/$month_interval==0?'-':number_format(array_sum($cost_goods)/$month_interval,2) ?>
      </td>
      <td>
        <?php $cost_gp =  (array_sum($cost_goods)/$total_income)*100 ?>
        <strong><?php echo number_format($cost_gp,2).'%' ?></strong>
      </td>
      <td></td>
      <td></td>
    </tr>
    <tr><!--empty space between datas-->
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr><!--empty space between datas-->

    <?php if ($searchModel->type_l == 'Coffee'): ?>
      <tr>
        <td></td>
        <td><strong>Gross Profit - Coffee</strong></td>
        <td>
          <?php $gross_coffee = $income_coffee-$cost_goods[0];?>
          <strong><?php echo number_format($gross_coffee,2) ?></strong>
        </td>
        <td>
          <strong> <?php echo $gross_coffee/$month_interval==0?'-':number_format($gross_coffee/$month_interval,2) ?></strong>
        </td>
        <td></td>
        <td>
          <?php if ($income_coffee != 0): ?>
            <?php $gp_coffee_per = ($gross_coffee/$income_coffee)*100 ?>
            <?php echo number_format($gp_coffee_per,2).'%' ?>
          <?php else: ?>
            <?php echo number_format(0,2).'%' ?>
          <?php endif; ?>
        </td>
        <td>
          <strong><?php echo $gross_coffee/$kg=='0'? '-':number_format($gross_coffee/$kg,3) ?></strong>
        </td>
      </tr>
    <?php elseif($searchModel->type_l == 'Tea'): ?>
      <tr>
        <td></td>
        <td><strong>Gross Profit - Tea</strong></td>
        <td>
          <?php $gross_tea = $income_tea-$cost_goods[1];?>
          <strong><?php echo number_format($gross_tea,2) ?></strong>
        </td>
        <td>
          <strong><?php echo $gross_tea/$month_interval==0?'-':number_format($gross_tea/$month_interval,2) ?></strong>
        </td>
        <td></td>
        <td>
          <?php if ($income_tea != 0): ?>
            <?php $gp_coffee_per = ($gross_tea/$income_tea)*100 ?>
            <?php echo number_format($gp_coffee_per,2).'%' ?>
          <?php else: ?>
            <?php echo number_format(0,2).'%' ?>
          <?php endif; ?>
        </td>
        <td>
          <strong><?php echo $gross_tea/$kg=='0'? '-':number_format($gross_tea/$kg,3) ?></strong>
        </td>

      </tr>
    <?php else: ?>
      <tr>
        <td></td>
        <td><strong>Gross Profit - Coffee</strong></td>
        <td>
          <?php $gross_coffee = $income_coffee-$cost_goods[0];?>
          <strong><?php echo number_format($gross_coffee,2) ?></strong>
        </td>
        <td>
          <strong> <?php echo $gross_coffee/$month_interval==0?'-':number_format($gross_coffee/$month_interval,2) ?></strong>
        </td>
        <td></td>
        <td>
          <?php if ($income_coffee != 0): ?>
            <?php $gp_coffee_per = ($gross_coffee/$income_coffee)*100 ?>
            <?php echo number_format($gp_coffee_per,2).'%' ?>
          <?php else: ?>
            <?php echo number_format(0,2).'%' ?>
          <?php endif; ?>
        </td>
        <td>
          <strong><?php echo $gross_coffee/$kg=='0'? '-':number_format($gross_coffee/$kg,3) ?></strong>
        </td>
      </tr>
      <tr>
        <td></td>
        <td><strong>Gross Profit - Tea</strong></td>
        <td>
          <?php $gross_tea = $income_tea-$cost_goods[1];?>
          <strong><?php echo number_format($gross_tea,2) ?></strong>
        </td>
        <td>
          <strong><?php echo $gross_tea/$month_interval==0?'-':number_format($gross_tea/$month_interval,2) ?></strong>
        </td>
        <td></td>
        <td>
          <?php if ($income_tea != 0): ?>
            <?php $gp_coffee_per = ($gross_tea/$income_tea)*100 ?>
            <?php echo number_format($gp_coffee_per,2).'%' ?>
          <?php else: ?>
            <?php echo number_format(0,2).'%' ?>
          <?php endif; ?>
        </td>
        <td>
          <strong><?php echo $gross_tea/$kg=='0'? '-':number_format($gross_tea/$kg,3) ?></strong>
        </td>

      </tr>
    <?php endif; ?>

    <tr>
      <td></td>
      <td><strong>Gross Profit - All</strong></td>
      <td>
        <?php $gross_all = $total_income - array_sum($cost_goods); ?>
        <strong><?php echo number_format($gross_all,2) ?></strong>
      </td>
      <td>
        <strong><?php echo $gross_all/$month_interval==0?'-':number_format($gross_all/$month_interval,2) ?></strong>
      </td>
      <td>
        <strong><?php echo number_format(100.00-$cost_gp,2).'%' ?></strong>
      </td>
      <td></td>
      <td><strong><?php echo $gross_all/$kg=='0'? '-':number_format($gross_all/$kg,3) ?></strong></td>
    </tr>
    <tr><!--empty space between datas-->
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr><!--empty space between datas-->
    <tr>
      <td colspan=2 class="column-head"> Individual Customer Expenses (Invoices) </td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>

    <!--Insert here for the loop sequence-->
    <?php foreach ($ind as $key => $value): ?>
      <?php
        $ind_sub = InvoicePerformance::find()->select(['average_cost','quantity'])
                ->andFilterWhere(['between', 'date', $date_from,$date_to])
                ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
                ->andFilterWhere(['amount'=>0])
                ->andFilterWhere(['item_name'=>$value['item_name']])
                ->asArray()
                ->orderBy(['item_name'=>SORT_ASC])
                ->all();
       ?>
       <?php foreach ($ind_sub as $key => $value_a): ?>
         <?php $ind_name = $value_a['average_cost']*$value_a['quantity'];
          $ind_total +=$ind_name;
       ?>
       <?php endforeach; ?>
        <?php $ind_summation[]=$ind_total ?>
      <tr>
        <td></td>
        <td> <?php echo $value['item_name'] ?></td>
        <td>
            <?php echo $ind_total == 0 ? '-':number_format($ind_total,2) ?>

        </td>
        <td>
          <?php echo $ind_total/$month_interval==0?'-':number_format($ind_total/$month_interval,2) ?>
        </td>
        <td>
          <?php echo $ind_total/$gross_all==0?'-':number_format($ind_total/$gross_all,2).'%' ?>
        </td>
        <td>
          <?php if ($gross_coffee != 0): ?>
            <?php $gp_coffee_per = ($ind_total/$gross_coffee)*100 ?>
            <?php echo number_format($gp_coffee_per,2).'%' ?>
          <?php else: ?>
            <?php echo number_format(0,2).'%' ?>
          <?php endif; ?>
        </td>
        <td>
          <?php echo $ind_total/$kg=='0'? '-':number_format($non_invoice /$kg,3) ?>
        </td>
        <?php $ind_total = 0; ?>
      </tr>
    <?php endforeach; ?>
      <!--Insert here for the loop sequence-->

    <tr>
      <td colspan=2 class="column-head"> Individual Customer Expenses (Non-Invoices)</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>

      <!--Execute Asset Type loop here edr-->
    <?php foreach ($asset as $key => $value): ?>
      <tr>
        <?php
          $non_invoice = DirectExpense::find()->where(['customer_name'=>$searchModel->customer_name, 'expense_type'=>$value['id'] ])
              ->andFilterWhere(['between','date',$date_from,$date_to])
              ->sum('expenses');
          $non_invoice_amount[] = $non_invoice;
         ?>
         <?php if (!empty($non_invoice) ): ?>
           <td></td>
           <td><?php echo $value['asset'] ?> </td>
           <td>
             <?php echo $non_invoice ==0?'-':number_format($non_invoice ,2) ?>
           </td>
           <td>
             <?php echo $non_invoice /$month_interval==0?'-':number_format($non_invoice /$month_interval,2) ?>
           </td>
           <td>
             <?php echo $non_invoice /$gross_all==0?'-':number_format( ($non_invoice /$gross_all)*100,2 ).'%' ?>
           </td>
           <td>
               <?php if ($gross_coffee != 0): ?>
                <?php $gp_coffee_per = ($non_invoice/$gross_coffee)*100 ?>
                <?php echo number_format($gp_coffee_per,2).'%' ?>
              <?php else: ?>
                <?php echo number_format(0,2).'%' ?>
              <?php endif; ?>
           </td>
           <td>
             <?php echo $non_invoice /$kg=='0'? '-':number_format($non_invoice /$kg,3) ?>
           </td>
         <?php endif; ?>

      </tr>
    <?php endforeach; ?>
      <!--Execute Asset Type loop. Ends here-->

    <tr>
      <td colspan=2 class="column-head"> Individual Customer Expenses (Assets) </td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td>Boiler's Depreciation</td>
      <td>
          <?php echo $boiler==0?'-':number_format($boiler,2) ?>
      </td>
      <td>
        <?php echo $boiler/$month_interval==0? '-': number_format($boiler/$month_interval,2) ?>
      </td>
      <td>
        <?php echo $boiler/$gross_all==0?'-':number_format( ($boiler/$gross_all)*100,2 ).'%' ?>
      </td>
      <td>
        <?php if ($gross_coffee != 0): ?>
          <?php $gp_coffee_per = ($boiler/$gross_coffee)*100 ?>
          <?php echo number_format($gp_coffee_per,2).'%' ?>
        <?php else: ?>
          <?php echo number_format(0,2).'%' ?>
        <?php endif; ?>
      </td>
      <td>
        <?php echo $boiler/$kg=='0'? '-':number_format($boiler/$kg,3) ?>
      </td>
    </tr>
    <tr>
      <td></td>
      <td><strong> Total Individual Customer Expenses </strong></td>
      <td>
        <?php //$individual_customer_expense = $non_ind+$non_group+array_sum($ind_summation)+$boiler ?>
          <?php $individual_customer_expense = array_sum($non_invoice_amount)+array_sum($ind_summation)+$boiler ?>

        <strong><?php echo $individual_customer_expense==0?'-':number_format($individual_customer_expense,2) ?></strong>
      </td>
      <td>
        <strong><?php echo $individual_customer_expense/$month_interval == 0? '-':number_format($individual_customer_expense/$month_interval,2) ?> </strong>
      </td>
      <td>
        <strong><?php echo $individual_customer_expense/$gross_all==0?'-':number_format( ($individual_customer_expense/$gross_all)*100,2 ).'%' ?></strong>
      </td>
      <td>
        <?php if ($gross_coffee != 0): ?>
          <?php $gp_coffee_per = ($individual_customer_expense/$gross_coffee)*100 ?>
          <strong><?php echo number_format($gp_coffee_per,2).'%' ?></strong>
        <?php else: ?>
          <strong><?php echo number_format(0,2).'%' ?></strong>
        <?php endif; ?>
      </td>
      <td>
        <strong>
          <?php echo $individual_customer_expense/$kg=='0'? '-':number_format($individual_customer_expense/$kg,3) ?>
        </strong>
      </td>
    </tr>
    <tr>
      <td colspan=2 class="column-head"> Shared Expenses (General)  </td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <!--start loop sequence herer /edr-->
    <?php foreach ($transact as $key => $value): ?>
      <tr>
        <td></td>
        <?php $account_codes = AccountList::find()->where(['transaction_group'=>$value])->asArray()->all(); ?>
        <?php $sums = [] ?>
        <?php foreach ($account_codes as $key => $value): ?>
          <?php $sums[] = ExpensesReport::find()->where(['id_code'=>$value['account']])
                  ->andWhere(['between','date_uploaded',$date_from,$date_to])
                  ->sum('debit'); ?>
        <?php endforeach; ?>
        <td>
          <?php echo $value['transaction_group']?>
          <!---<span> <?php echo str_repeat("&nbsp",20).number_format(array_sum($sums),2) ?></span>--->
        </td>
        <td>
          <?php //$shared = (array_sum($sums)/$gross_all)/10000 ?>
          <?php $shared = array_sum($sums)/$gp_leong?>
          <?php $shared_expense = $gross_all*$shared ?>
          <?php $shared_expenses_total[] =  $shared_expense?>
          <?php echo number_format($shared_expense,2) ?>
          <br>

        </td>
        <td>
          <?php echo number_format(($shared_expense/$month_interval),2) ?>
        </td>
        <td>
          <?php echo number_format($shared*100,2).'%' ?>
        </td>
        <td>
          <?php if ($gross_coffee != 0): ?>
            <?php $gp_coffee_per = ($shared_expense/$gross_coffee)*100 ?>
            <?php echo number_format($gp_coffee_per,2).'%' ?>
          <?php else: ?>
            <?php echo number_format(0,2).'%' ?>
          <?php endif; ?>
        </td>
        <td><?php echo number_format(($shared_expense/$kg),3) ?></td>
      </tr>
    <?php endforeach; ?>

    <!--end loop sequence here-->

    <tr>
      <td colspan=2 class="column-head"> Shared Expenses (Others)  </td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td>Cost Variance</td>
      <td>0</td>
      <td>0</td>
      <td>0</td>
      <td>0</td>
      <td>0</td>
    </tr>
    <tr>
      <td></td>
      <td><strong>Total Shared Expenses</strong> </td>
      <td>
        <strong><?php echo number_format(array_sum($shared_expenses_total),2) ?></strong>
      </td>
      <td>
        <strong><?php echo number_format(array_sum($shared_expenses_total)/$month_interval,2) ?> </strong>
      </td>
      <td>
        <?php //$shared = (array_sum($sums)/$gross_all)/100 ?>
        <?php $test = (array_sum($shared_expenses_total)/$gross_all)*100 ?>
        <?php echo number_format($test,2).'%' ?>
      </td>
      <td>
        <?php if ($gross_coffee != 0): ?>
          <?php $gp_coffee_per = (array_sum($shared_expenses_total)/$gross_coffee)*100 ?>
          <?php echo number_format($gp_coffee_per,2).'%' ?>
        <?php else: ?>
          <?php echo number_format(0,2).'%' ?>
        <?php endif; ?>
      </td>
      <td>
        <strong> <?php echo number_format(array_sum($shared_expenses_total)/$kg,3) ?>  </strong></td>
    </tr>
    <tr><!--empty space between datas-->
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr><!--empty space between datas-->
    <tr>
      <td colspan="2"><h4>Net Profit</h4> </td>
      <td>
        <?php $net_profit = $gross_all-($individual_customer_expense + array_sum($shared_expenses_total)) ?>
        <h4><?php echo number_format($net_profit,2) ?></h4>
      </td>
      <td>
        <h4><?php echo number_format($net_profit/$month_interval,2) ?></h4>
      </td>
      <td>
        <?php $shared = ($net_profit/$gross_all)/100 ?>
        <h4><?php echo number_format($shared,2).'%' ?></h4>
      </td>
      <td>
        <?php if ($gross_coffee != 0): ?>
          <?php $gp_coffee_per = ($net_profit/$gross_coffee)*100 ?>
          <h4><?php echo number_format($gp_coffee_per,2).'%' ?></h4>
        <?php else: ?>
          <h4><?php echo number_format(0,2).'%' ?></h4>
        <?php endif; ?>
      </td>
      <td>
        <h4><?php echo number_format($net_profit/$kg,3) ?></h4>
      </td>
    </tr>

  </table>


<?php
  $data_test = 'AccountList';
 ?>
  <hr><br>
  <table class="table">

  </table>
