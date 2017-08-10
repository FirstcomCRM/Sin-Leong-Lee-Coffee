<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "invoice_quantity".
 *
 * @property integer $id
 * @property string $item_name
 * @property string $item_code
 * @property string $total_quantity
 * @property string $total_amount
 * @property integer $invoice_id
 */
class InvoiceQuantity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice_quantity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['total_quantity', 'total_amount'], 'number'],
            [['invoice_id'], 'required'],
            [['invoice_id'], 'integer'],
            [['item_name', 'item_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_name' => 'Item Name',
            'item_code' => 'Item Code',
            'total_quantity' => 'Total Quantity',
            'total_amount' => 'Total Amount',
            'invoice_id' => 'Invoice ID',
        ];
    }
}
