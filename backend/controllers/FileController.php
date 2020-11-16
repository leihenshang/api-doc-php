<?php

namespace app\controllers;

use app\behaviors\UserVerify;
use Yii;
use yii\base\DynamicModel;
use yii\web\UploadedFile;

class FileController extends BaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['userVerify'] = [
            'class' => UserVerify::class,
//            'actions' => ['upload-img'],  //设置要验证的action,如果留空或者里边放入 * ，则所有的action都要执行验证
            'excludeAction' => [], //要排除的action,在此数组内的action不执行登陆状态验证
        ];
        return $behaviors;
    }

    public function actionUploadImg()
    {
        if (!Yii::$app->request->isPost) {
            return $this->failed('必须使用POST方法');
        }

        $file = UploadedFile::getInstanceByName('img');
        $model = DynamicModel::validateData(['img' => $file],
            [[['img'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg']]
        );

        if (!$model->validate()) {
            return $this->failed(current($model->getFirstErrors()));
        }

        $savePath = Yii::getAlias('@app/web') . DIRECTORY_SEPARATOR . 'uploads';
        if (!is_dir($savePath)) {
            if (!mkdir($savePath)) {
                return $this->failed('创建文件夹失败');
            }
        }

        //保存文件
        $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);

        return $this->success();
    }
}