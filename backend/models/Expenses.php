<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "expenses".
 *
 * @property integer $id
 * @property string $month
 * @property string $total
 */
class Expenses extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'expenses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['month', 'total'], 'required'],
            [['total'], 'number'],
            [['month'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'month' => 'Month',
            'total' => 'Total',
            'file' => 'Import File',
        ];
    }
}
