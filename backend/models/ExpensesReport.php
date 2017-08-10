<?php

namespace backend\models;

use Yii;

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
}
