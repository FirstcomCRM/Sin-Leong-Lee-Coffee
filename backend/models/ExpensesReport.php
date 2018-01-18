<?php

namespace backend\models;

use Yii;
use backend\models\ExpensesReport;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "expenses_report".
 *
 * @property integer $id
 * @property string $id_no
 * @property string $scr
 * @property string $date
 * @property string $memo
 * @property string $debit
 * @property string $credit
 * @property string $job_no
 * @property string $net_activity
 * @property string $ending_balance
 * @property integer $expenses_id
 */
class ExpensesReport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     public $year_to;
     public $month_to;
     public $year_from;
     public $month_from;
     public $customer;

    public static function tableName()
    {
        return 'expenses_report';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['expenses_id'], 'required'],
            [['expenses_id'], 'integer'],
            [['year_to','month_to','year_from','month_from',],'safe'],
            [['id_no', 'scr', 'date', 'memo', 'debit', 'credit', 'job_no', 'net_activity', 'ending_balance'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_no' => 'Id No',
            'scr' => 'Scr',
            'date' => 'Date',
            'memo' => 'Memo',
            'debit' => 'Debit',
            'credit' => 'Credit',
            'job_no' => 'Job No',
            'net_activity' => 'Net Activity',
            'ending_balance' => 'Ending Balance',
            'expenses_id' => 'Expenses ID',
        ];
    }

    public function perform_list($params){
      $query = ExpensesReport::find();

      $dataProvider = new ActiveDataProvider([
          'query' => $query,
      ]);

       $this->load($params);

       $ym_from = $this->month_from.'-'.$this->year_from;
       $ym_to = $this->month_to.'-'.$this->year_to;
       $date_from = date('Y-m-01', strtotime($ym_from));
       $date_to = date('Y-m-t', strtotime($ym_to));

       $query->andFilterWhere(['between','date_uploaded',$date_from,$date_to]);

       return $dataProvider;
    }
}
