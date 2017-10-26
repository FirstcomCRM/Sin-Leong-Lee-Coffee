<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "item_list".
 *
 * @property integer $id
 * @property string $item
 * @property string $item_name
 * @property string $asset
 * @property string $income
 * @property string $exp_cos
 */
class ItemList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item', 'item_name', 'asset', 'income', 'exp_cos'], 'required'],
            [['item'], 'string', 'max' => 20],
            [['item_name'], 'string', 'max' => 50],
            [['asset', 'income', 'exp_cos'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item' => 'Item',
            'item_name' => 'Item Name',
            'asset' => 'Asset',
            'income' => 'Income',
            'exp_cos' => 'Exp Cos',
        ];
    }
}
