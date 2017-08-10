<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "permission".
 *
 * @property integer $id
 * @property integer $role_id
 * @property string $controller
 * @property string $permission
 */
class Permission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'permission';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['role_id', 'controller', 'permission'], 'required'],
            [['role_id'], 'integer'],
            [['permission'], 'string'],
            [['controller'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'controller' => 'Controller',
            'permission' => 'Permission',
        ];
    }
}
