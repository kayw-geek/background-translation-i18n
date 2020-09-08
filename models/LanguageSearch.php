<?php


namespace weikaiiii\backgroundTranslationI18n\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use weikaiiii\backgroundTranslationI18n\models\SearchTrait;
use weikaiiii\backgroundTranslationI18n\models\Language;

/**
 * LanguageSearch represents the model behind the search form about `common\models\Language`.
 */
class LanguageSearch extends Language
{
    use SearchTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['language_id', 'language', 'country', 'name', 'name_ascii'], 'safe'],
            [['status'], 'integer'],
        ];
    }

    /**
     * The name of the default scenario.
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @param array $params Search conditions.
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Language::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'status' => $this->status,
        ]);

        $query->andFilterWhere($this->createLikeExpression('language_id', $this->language_id))
            ->andFilterWhere($this->createLikeExpression('language', $this->language))
            ->andFilterWhere($this->createLikeExpression('country', $this->country))
            ->andFilterWhere($this->createLikeExpression('name', $this->name))
            ->andFilterWhere($this->createLikeExpression('name_ascii', $this->name_ascii));

        return $dataProvider;
    }
}
