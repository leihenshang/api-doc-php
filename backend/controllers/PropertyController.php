<?php

namespace app\controllers;

use app\models\Property;
use yii\helpers\ArrayHelper;

class PropertyController extends BaseController
{
    public function actionList()
    {
        $type = \Yii::$app->request->get('tag',null);
        $res = Property::find()->select('tag,tag_name,description');
        if($type){
          $res =   $res->where(['tag' => $type])->all();
        }else{
            $res = $res->all();
        }
        if($res) {
            $res = ArrayHelper::index($res, null, 'tag');
        }
        return ['data' => $res];
    }

}
