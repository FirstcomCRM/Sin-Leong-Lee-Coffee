<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "setup".
 *
 * @property integer $id
 * @property integer $up
 * @property integer $down
 */
class Setup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['up', 'down'], 'required'],
            [['up', 'down'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'up' => 'Up',
            'down' => 'Down',
        ];
    }
}
