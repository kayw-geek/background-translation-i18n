<?php
/**
 * Created by PhpStorm.
 * @name:
 * @author: weikai
 * @date: dt
 */
namespace weikaiiii\backgroundTranslationI18n\controllers;

use yii\web\Controller;
use weikaiiii\backgroundTranslationI18n\models\TranslateJsonKeyModel;
use weikaiiii\backgroundTranslationI18n\models\TranslateJsonKey;
use weikaiiii\backgroundTranslationI18n\models\TranslateJsonValue;
use weikaiiii\backgroundTranslationI18n\models\LanguageSearch;
use Yii;
use yii\web\JsonResponseFormatter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\web\XmlResponseFormatter;

class TranslateJsonController extends Controller
{
    public function actionIndex(  )
    {
        $searchModel = new TranslateJsonKeyModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $lang_id = Yii::$app->request->get('language_id');
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'lang_id' => $lang_id,
        ]);
    }

    public function actionList(  )
    {
        $searchModel = new LanguageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $dataProvider->sort = ['defaultOrder' => ['status' => SORT_DESC]];

        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionCreate()
    {
        $model = new TranslateJsonKey();
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $model->load($post);
            $lang_code = $post['TranslateJsonKey']['lang_code'];
            $model->file = UploadedFile::getInstance($model, 'file');
            $jsonData = json_decode(file_get_contents($model->file->tempName), true);
            if (empty($jsonData)) return $this->redirect(['create']);
            $categoryName = '';
            foreach ($jsonData as $k => $v) {
                $categoryName = $k;
                foreach ($v as $key=>$value) {
                    $reData = TranslateJsonKey::find()
                        ->where(['category_name'=>$categoryName,'key'=>$key])
                        ->one();
                    if (!empty($reData)){
                        $reDataModel = TranslateJsonValue::find()->where(['key_id'=>$reData->id,'lang_code'=>$model->lang_code])->one();
                        if (!empty($reDataModel)){
                            $reDataModel->value = $value;
                            $reDataModel->save(false);
                        }else{
                            $modelValue = new TranslateJsonValue();
                            $modelValue->key_id = $reData->id;
                            $modelValue->lang_code = $model->lang_code;
                            $modelValue->value = $value;
                            $modelValue->save(false);
                        }
                    }else{
                        $keyModel = new TranslateJsonKey();
                        $keyModel->category_name = $categoryName;
                        $keyModel->key = $key;
                        $keyModel->save(false);
                        $keyId = $keyModel->id;
                        $valueModel = new TranslateJsonValue();
                        $valueModel->key_id = $keyId;
                        $valueModel->lang_code = $model->lang_code;
                        $valueModel->value = $value;
                        $valueModel->save(false);
                    }

                }
            }

            return $this->redirect(['list']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionExport(  )
    {
        if (Yii::$app->request->post()){
            $lang_code = Yii::$app->request->post('TranslateJsonValue')['lang_code'];
            $exportData = TranslateJsonValue::find()
                ->select('k.category_name,k.key,translate_json_value.value')
                ->leftJoin('translate_json_key as k','translate_json_value.key_id=k.id')
                ->where(['lang_code'=>$lang_code])
                ->asArray()
                ->all();
            $array = [];
            $tmp = '';
            foreach ($exportData as $k=> $v){
                $array[$v['category_name']][$v['key']] = $v['value'];
            }

            $file = 'Translate_'.$lang_code.'_'.date('Y-m-d-h-i-s').'.json';
            Yii::$app->response->format = 'json';

            Yii::$app->response->formatters = [
                Response::FORMAT_JSON => [
                    'class' => JsonResponseFormatter::className(),
                ],
            ];

            Yii::$app->response->setDownloadHeaders($file);
            Yii::$app->session->setFlash('success','Export successfully');
            return $array;
        }
        $model = new TranslateJsonValue();
        return $this->render('export', ['model'=> $model]);

    }
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = TranslateJsonKey::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}