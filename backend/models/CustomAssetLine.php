<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "custom_asset_line".
 *
 * @property integer $id
 * @property integer $custom_asset_id
 * @property string $date_from
 * @property string $date_to
 * @property string $dep_amount
 * @property string $dep_expense
 * @property string $customer_name
 */
class CustomAssetLine extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'custom_asset_line';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        //    [['custom_asset_id'], 'required'],
            [['custom_asset_id'], 'integer'],
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
            'custom_asset_id' => 'Custom Asset ID',
            'date_from' => 'Date From',
            'date_to' => 'Date To',
            'dep_amount' => 'Dep Amount',
            'dep_expense' => 'Dep Expense',
            'customer_name' => 'Customer Name',
        ];
    }
}
