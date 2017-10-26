<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "direct_expense".
 *
 * @property integer $id
 * @property integer $expense_type
 * @property string $customer_name
 * @property string $date
 * @property string $expenses
 * @property string $date_created
 */
class DirectExpense extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'direct_expense';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['expense_type', 'customer_name', 'date', 'expenses'], 'required'],
            [['expense_type'], 'integer'],
            [['date', 'date_created'], 'safe'],
            [['expenses'], 'number'],
            [['customer_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'expense_type' => 'Expense Type',
            'customer_name' => 'Customer Name',
            'date' => 'Date',
            'expenses' => 'Expenses Amount',
            'date_created' => 'Date Created',
        ];
    }
}
