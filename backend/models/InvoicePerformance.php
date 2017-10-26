<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "invoice_performance".
 *
 * @property integer $id
 * @property string $customer_name
 * @property string $invoice_no
 * @property string $date
 * @property string $quantity
 * @property string $amount
 * @property string $average_cost
 * @property string $job_no
 * @property string $sales_person
 * @property string $customer_card_id
 * @property string $invoice_item_code
 * @property integer $invoice_id
 */
class InvoicePerformance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice_performance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['customer_name', 'invoice_no', 'date', 'quantity', 'amount', 'average_cost', 'job_no', 'customer_card_id', 'invoice_item_code', 'invoice_id'], 'required'],
            [['quantity', 'amount'], 'number'],
            [['invoice_id'], 'integer'],
            [['item_code','item_name','item_abbr'],'safe'],
            [['customer_name', 'invoice_no', 'date', 'average_cost', 'job_no', 'sales_person', 'customer_card_id', 'invoice_item_code'], 'string', 'max' => 255],
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
            'invoice_no' => 'Invoice No',
            'date' => 'Date',
            'quantity' => 'Quantity',
            'amount' => 'Amount',
            'average_cost' => 'Average Cost',
            'job_no' => 'Job No',
            'sales_person' => 'Sales Person',
            'customer_card_id' => 'Customer Card ID',
            'invoice_item_code' => 'Invoice Item Code',
            'invoice_id' => 'Invoice ID',
            'item_code'=>'Item Code',
            'item_name'=>'Item Name',
            'item_abbr'=> 'Item Abbr',
        ];
    }
}
