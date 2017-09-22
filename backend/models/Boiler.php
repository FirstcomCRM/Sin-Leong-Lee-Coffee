<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "boiler".
 *
 * @property integer $id
 * @property string $customer
 * @property string $bolter_no
 * @property string $invoice_no
 * @property string $pur_date
 * @property string $pur_cost
 * @property string $cost
 * @property string $acc_depn
 * @property string $year
 * @property string $depn
 * @property string $nbv
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
            [['customer', 'bolter_no', 'invoice_no', 'pur_date', 'pur_cost', 'cost', 'acc_depn', 'year'], 'required'],
            [['cost', 'depn', 'nbv','acc_depn'], 'number'],
            [['year'], 'safe'],
            [['customer', 'bolter_no', 'invoice_no', 'pur_date', 'pur_cost'], 'string', 'max' => 255],
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
            'bolter_no' => 'Bolter No',
            'invoice_no' => 'Invoice No',
            'pur_date' => 'Purchase Date',
            'pur_cost' => 'Purchase Cost',
            'cost' => 'Cost',
            'acc_depn' => 'Acc Depn',
            'year' => 'Year',
            'depn' => 'Depn',
            'nbv' => 'Nbv',
        ];
    }
}
