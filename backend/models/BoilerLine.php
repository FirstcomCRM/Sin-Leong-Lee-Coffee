<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "boiler_line".
 *
 * @property integer $id
 * @property integer $boiler_id
 * @property string $years
 * @property string $dep_amount
 * @property string $dep_expense
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
            [['boiler_id'], 'integer'],
            [['years'], 'safe'],
            [['dep_amount', 'dep_expense'], 'number'],
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
            'years' => 'Years',
            'dep_amount' => 'Depreciation Amount',
            'dep_expense' => 'Depreciation Expense',
        ];
    }
}
