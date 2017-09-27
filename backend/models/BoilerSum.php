<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "boiler_sum".
 *
 * @property integer $id
 * @property integer $boiler_id
 * @property string $year_from
 * @property string $year_to
 * @property string $purchase_cost
 * @property integer $total_dep_year
 * @property string $total_dep_amount
 * @property string $balance
 */
class BoilerSum extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'boiler_sum';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['boiler_id', 'total_dep_year'], 'integer'],
            [['year_from', 'year_to'], 'safe'],
            [['purchase_cost', 'total_dep_amount', 'balance'], 'number'],
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
            'year_from' => 'Year From',
            'year_to' => 'Year To',
            'purchase_cost' => 'Purchase Cost',
            'total_dep_year' => 'Total Depreciation Years',
            'total_dep_amount' => 'Total Depreciation Amount',
            'balance' => 'Balance',
        ];
    }
}
