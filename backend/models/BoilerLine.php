<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "boiler_line".
 *
 * @property integer $id
 * @property integer $boiler_id
 * @property string $date_from
 * @property string $date_to
 * @property string $dep_amount
 * @property string $dep_expense
 * @property string $customer_name
 */
class BoilerLine extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'boiler_line';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_from', 'date_to', 'dep_amount', 'dep_expense', 'customer_name'], 'required'],
            [['boiler_id'], 'integer'],
            [['date_from', 'date_to'], 'safe'],
            [['dep_amount', 'dep_expense'], 'number'],
            [['customer_name'], 'string', 'max' => 75],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'boiler_id' => 'Boiler ID',
            'date_from' => 'Date From',
            'date_to' => 'Date To',
            'dep_amount' => 'Dep Amount',
            'dep_expense' => 'Dep Expense',
            'customer_name' => 'Customer Name',
        ];
    }
}
