<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\TranslateJsonKey */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Translate Json Keys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="translate-json-key-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

   <?php
   $data =  \common\models\TranslateJsonValue::find()
       ->where(['key_id'=>$model->id])
       ->asArray()
       ->all();
   echo "<h3>译文</h3>";
   foreach ($data as $v){
       echo '<h3>'.$v['lang_code'].':  '.$v['value'].'<br/><h3/>';
   };
   ?>

</div>
