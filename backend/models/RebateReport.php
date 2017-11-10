<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "rebate_report".
 *
 * @property integer $id
 * @property string $customer
 * @property string $class
 * @property string $date
 * @property integer $quantity
 * @property string $account
 * @property string $description
 * @property string $amount
 * @property string $tax
 * @property string $job_no
 */
class RebateReport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rebate_report';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['quantity'], 'integer'],
            [['amount'], 'number'],
            [['customer'], 'string', 'max' => 125],
            [['class'], 'string', 'max' => 30],
            [['account'], 'string', 'max' => 20],
            [['description'], 'string', 'max' => 75],
            [['tax', 'job_no'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer' => 'Customer',
            'class' => 'Class',
            'date' => 'Date',
            'quantity' => 'Quantity',
            'account' => 'Account',
            'description' => 'Description',
            'amount' => 'Amount',
            'tax' => 'Tax',
            'job_no' => 'Job No',
        ];
    }
}
