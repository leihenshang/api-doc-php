<?php

namespace app\controllers;

use app\models\Property;
use Yii;
use yii\helpers\ArrayHelper;

class PropertyController extends BaseController
{
    public function actionList()
    {
        $type = Yii::$app->request->get('tag', null);
        $res = Property::find()->select('tag,tag_name,description');
        if ($type) {
            $res = $res->where(['tag' => $type])->all();
        } else {
            $res = $res->all();
        }
        if ($res) {
            $res = ArrayHelper::index($res, null, 'tag');
        }

        $varType = $res['var_type'];

        $type = array_column($varType,null,'tag_name');
        $typeKey = array_keys($type);
        sort($typeKey);

        $sortVarType = [];
        foreach ($typeKey as $value){
            $sortVarType[] = $type[$value];
        }

        $res['var_type'] = $sortVarType;

        return $this->success($res);
    }

}
