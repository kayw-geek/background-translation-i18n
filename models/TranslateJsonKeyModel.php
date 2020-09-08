<?php

namespace weikaiiii\backgroundTranslationI18n\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use weikaiiii\backgroundTranslationI18n\models\TranslateJsonKey;

/**
 * TranslateJsonKeyModel represents the model behind the search form of `common\models\TranslateJsonKey`.
 */

class TranslateJsonKeyModel extends TranslateJsonKey
{
    public $value;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['category_name', 'key','value'], 'safe'],
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
        $query = TranslateJsonKey::find();
        $query->joinWith(['tvalue']);
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
        ]);
        $query->andFilterWhere(['like', 'category_name', $this->category_name])
            ->andFilterWhere(['like', 'translate_json_value.value', $this->value]);
        $query->orderBy([ 'id' => SORT_DESC ]);

        return $dataProvider;
    }
}
