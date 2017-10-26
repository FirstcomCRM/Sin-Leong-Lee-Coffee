<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "asset_type".
 *
 * @property integer $id
 * @property string $asset
 */
class AssetType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asset_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          //  [['id', 'asset'], 'required'],
          //  [['id'], 'integer'],
            [['asset'],'required'],
            [['asset'], 'string', 'max' => 75],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'asset' => 'Asset',
        ];
    }
}
