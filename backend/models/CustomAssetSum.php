<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "custom_asset_sum".
 *
 * @property integer $id
 * @property integer $custom_asset_id
 * @property string $bolter_no
 * @property string $invoice_no
 * @property string $purchase_cost
 * @property string $customer_name
 * @property string $purchase_date
 * @property string $cost
 * @property string $acc_depn
 * @property string $depn
 * @property string $nbv
 * @property string $year
 * @property string $date_from
 * @property string $date_to
 * @property integer $total_dep_year
 * @property string $total_dep_amount
 * @property string $balance
 * @property integer $depn_rate
 */
class CustomAssetSum extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'custom_asset_sum';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        //    [['custom_asset_id', 'year'], 'required'],
            [['depn_rate', ], 'required'],
            [['custom_asset_id', 'total_dep_year', 'depn_rate'], 'integer'],
            [['purchase_cost', 'cost', 'acc_depn', 'depn', 'nbv', 'total_dep_amount', 'balance'], 'number'],
            [['purchase_date', 'year', 'date_from', 'date_to'], 'safe'],
            [['bolter_no', 'invoice_no'], 'string', 'max' => 25],
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
            'bolter_no' => 'Customer Asset No',
            'invoice_no' => 'Invoice No',
            'purchase_cost' => 'Purchase Cost',
            'customer_name' => 'Customer Name',
            'purchase_date' => 'Purchase Date',
            'cost' => 'Cost',
            'acc_depn' => 'Acc Depn',
            'depn' => 'Depn',
            'nbv' => 'Nbv',
            'year' => 'Year',
            'date_from' => 'Date From',
            'date_to' => 'Date To',
            'total_dep_year' => 'Total Dep Year',
            'total_dep_amount' => 'Total Dep Amount',
            'balance' => 'Balance',
            'depn_rate' => 'Depn Rate',
        ];
    }
}
