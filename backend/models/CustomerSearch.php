<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\InvoicePerformance;

/**
 * CustomerSearch represents the model behind the search form about `backend\models\InvoicePerformance`.
 */
class CustomerSearch extends InvoicePerformance
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'invoice_id'], 'integer'],
            [['customer_name', 'invoice_no', 'date', 'average_cost', 'job_no', 'sales_person', 'customer_card_id', 'invoice_item_code'], 'safe'],
            [['quantity', 'amount'], 'number'],
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
        $query = InvoicePerformance::find();

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
            'quantity' => $this->quantity,
            'amount' => $this->amount,
            'invoice_id' => $this->invoice_id,
        ]);

        $query->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'invoice_no', $this->invoice_no])
            ->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'average_cost', $this->average_cost])
            ->andFilterWhere(['like', 'job_no', $this->job_no])
            ->andFilterWhere(['like', 'sales_person', $this->sales_person])
            ->andFilterWhere(['like', 'customer_card_id', $this->customer_card_id])
            ->andFilterWhere(['like', 'invoice_item_code', $this->invoice_item_code]);

        return $dataProvider;
    }

    public function customer_list_all($customer = null,$month_from = null,$month_to = null,$year_from = null,$year_to = null){

        $sql = "SELECT a.customer_name,a.year,a.month,SUM(a.amount) AS amount, SUM(average_cost) AS average_cost,a.customer_card_id,a.expenses
                    FROM (SELECT a.customer_name, YEAR(a.date) AS year, MONTH(a.date) AS month,a.amount,a.quantity * a.average_cost AS average_cost ,a.customer_card_id,b.total AS expenses
                    FROM invoice_performance a
                    LEFT JOIN (SELECT MONTH , total FROM expenses) b
                    ON MONTH(b.month) = MONTH(a.date) AND YEAR(b.month) = YEAR(a.date))  a   ";


        if ($customer != null && $month_from != null && $month_to != null && $year_from != null && $year_to != null) {

            $sql .= " where a.customer_name = '".$customer."' and a.month  BETWEEN '".$month_from."' AND '".$month_to."' and a.year  BETWEEN '".$year_from."' AND '".$year_to."'";
        }
        //and else $customer
        $sql .= " GROUP BY YEAR,MONTH,customer_name,customer_card_id";

        return $result = Yii::$app->db->createCommand($sql)->queryAll();
    }

    public function customer_list_daterange($month_from = null,$month_to = null,$year_from = null,$year_to = null){

              $sql = "SELECT a.customer_name,a.year,a.month,SUM(a.amount) AS amount, SUM(average_cost) AS average_cost,a.customer_card_id,a.expenses
                          FROM (SELECT a.customer_name, YEAR(a.date) AS year, MONTH(a.date) AS month,a.amount,a.quantity * a.average_cost AS average_cost ,a.customer_card_id,b.total AS expenses
                          FROM invoice_performance a
                          LEFT JOIN (SELECT MONTH , total FROM expenses) b
                          ON MONTH(b.month) = MONTH(a.date) AND YEAR(b.month) = YEAR(a.date))  a   ";


              if ($month_from != null && $month_to != null && $year_from != null && $year_to != null) {

                  $sql .= "where a.month  BETWEEN '".$month_from."' AND '".$month_to."' and a.year  BETWEEN '".$year_from."' AND '".$year_to."'";
              }
              //and else $customer
              $sql .= " GROUP BY YEAR,MONTH,customer_name,customer_card_id";

              return $result = Yii::$app->db->createCommand($sql)->queryAll();

    }

}
