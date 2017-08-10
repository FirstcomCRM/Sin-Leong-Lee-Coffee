<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Permission;

/**
 * PermissionSearch represents the model behind the search form about `backend\models\Permission`.
 */
class PermissionSearch extends Permission
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'role_id'], 'integer'],
            [['controller', 'permission'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Permission::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'role_id' => $this->role_id,
        ]);

        $query->andFilterWhere(['like', 'controller', $this->controller])
            ->andFilterWhere(['like', 'permission', $this->permission]);

        return $dataProvider;
    }
    public function list_view($role = null,$controller = null,$permission = null)
    {
        
        $sql = "SELECT a.id, a.user_role, b.role_id, b.controller, b.permission
                FROM user_role a
                LEFT JOIN permission b 
                ON a.id = b.role_id";

        if ($role != null) {
            //$sql .= " AND a.job_no LIKE '%".$choice."%'";
            $sql .= " WHERE a.user_role = '".$role."'";
        }
        if ($controller != null){
            $sql .= " AND b.controller = '".$controller."'";
        }
        if ($permission != null){
            $sql .= " AND b.permission LIKE '%".$permission."%'";
        }

        return $result = Yii::$app->db->createCommand($sql)->queryAll();
    }
    public function list_update($id = null)
    {
        
        $sql = "SELECT a.id, a.user_role, b.role_id, b.controller, b.permission
                FROM user_role a
                LEFT JOIN permission b 
                ON a.id = b.role_id";

        if ($id != null) {

            $sql .= " WHERE a.id = '".$id."'";
        }
        

        return $result = Yii::$app->db->createCommand($sql)->queryAll();
    }
}
