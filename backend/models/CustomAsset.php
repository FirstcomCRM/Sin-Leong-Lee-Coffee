<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "custom_asset".
 *
 * @property integer $id
 * @property string $customer_name
 * @property string $purchase_date
 * @property string $amount
 */
class CustomAsset extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'custom_asset';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_name', 'purchase_date'], 'required'],
            [['purchase_date'], 'safe'],
            [['amount'], 'number'],
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
            'customer_name' => 'Customer Name',
            'purchase_date' => 'Purchase Date',
            'amount' => 'Amount',
        ];
    }
}
