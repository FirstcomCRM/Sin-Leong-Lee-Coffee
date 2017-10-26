<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\InvoiceQuantity;

/**
 * InvoiceQuantitySearch represents the model behind the search form about `backend\models\InvoiceQuantity`.
 */
class InvoiceQuantitySearch extends InvoiceQuantity
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'invoice_id'], 'integer'],
            [['item_name', 'item_code'], 'safe'],
            [['total_quantity', 'total_amount'], 'number'],
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
        $query = InvoiceQuantity::find();

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
            'total_quantity' => $this->total_quantity,
            'total_amount' => $this->total_amount,
            'invoice_id' => $this->invoice_id,
        ]);

        $query->andFilterWhere(['like', 'item_name', $this->item_name])
            ->andFilterWhere(['like', 'item_code', $this->item_code]);

        return $dataProvider;
    }

    public function quantity_list($month = null,$year = null)
    {


        $sql = "SELECT  a.item_name, b.month, a.item_code, a.total_quantity
                    FROM invoice_quantity a
                    LEFT JOIN invoice b ON a.invoice_id = b.id";

        if ($year != null && $month != null) {

            $sql .= " where b.month = '".$month.' - '.$year."'";
        }

        return $result = Yii::$app->db->createCommand($sql)->queryAll();
    }

    
}
