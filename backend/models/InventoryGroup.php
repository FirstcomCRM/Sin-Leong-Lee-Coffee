<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "inventory_group".
 *
 * @property integer $id
 * @property string $inventory_group
 */
class InventoryGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inventory_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['inventory_group'], 'required'],
            [['inventory_group'], 'string', 'max' => 75],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'inventory_group' => 'Inventory Group',
        ];
    }
}
