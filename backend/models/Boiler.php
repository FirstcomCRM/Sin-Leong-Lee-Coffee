<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "boiler".
 *
 * @property integer $id
 * @property string $customer_name
 * @property integer $assete_type
 * @property string $purchase_date
 * @property string $amount
 */
class Boiler extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'boiler';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_name', 'purchase_date'], 'required'],
            //[['asset_type'], 'integer'],
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
          //  'asset_type' => 'Asset Type',
            'purchase_date' => 'Purchase Date',
            'amount' => 'Amount',
        ];
    }
}
