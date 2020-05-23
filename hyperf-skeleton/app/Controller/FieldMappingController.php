<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use App\Helper\Helper;
use App\Middleware\Auth\AuthMiddleware;
use App\Model\FieldMapping;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

/**
 * @Controller(prefix="field-mapping")
 * Class FieldMappingController
 * @package App\Controller
 */
class FieldMappingController extends AbstractController
{

    /**
     * @Inject()
     * @var ValidatorFactoryInterface
     */
    protected $validationFactory;

    /**
     * @RequestMapping(path="list",methods="get")
     * @return array
     */
    public function list()
    {
        $validator = $this->validationFactory->make(
            $this->request->all(),
            [
                'project_id' => 'required'
            ]
        );

        if ($validator->fails()) {
            return Helper::failed($validator->errors()->first());
        }
        $reqData = $validator->validated();
        $data = FieldMapping::query()->where([
            'project_id' => $reqData['project_id'],
            'is_deleted' => FieldMapping::IS_DELETED['no']
        ])
            ->orderBy('create_time', 'desc')
            ->get();
        return Helper::success($data);
    }

    /**
     * 创建映射
     * @RequestMapping(path="create",methods="post")
     * @Middleware(AuthMiddleware::class)
     */
    public function create()
    {
        $validator = $this->validationFactory->make(
            $this->request->all(),
            [
                'field' => 'required',
                'type' => 'required',
                'description' => 'required',
                'project_id' => 'required'
            ]
        );

        if ($validator->fails()) {
            return Helper::failed($validator->errors()->first());
        }

        $data = $validator->validated();

        //检查同一项目字段映射是否重复
        $oldData = FieldMapping::query()->where([
            'field' => $data['field'],
            'project_id' => $data['project_id'],
        ])->where('is_deleted', FieldMapping::IS_DELETED['no'])->first();
        if ($oldData) {
            return $this->failedToJson('字段名名重复');
        }

        $model = new FieldMapping();
        $model->project_id = $data['project_id'];
        $model->type = $data['type'];
        $model->field = $data['field'];
        $model->description = $data['description'];
        if ($model->save()) {
            return $this->toJson();
        }

        return $this->failedToJson();
    }

    /**
     * 更新映射名
     * @RequestMapping(path="update",methods="post")
     */
    public function update()
    {
        $validate = $this->validationFactory->make($this->request->post(), [
            'id' => 'required|numeric',
            'field' => 'required|string',
            'type' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validate->fails()) {
            $errorMessage = $validate->errors()->first();
            return Helper::failed($errorMessage);
        }

        $data = $validate->validated();
        $updateData = FieldMapping::query()->where('id', $data['id'])->where('is_deleted', FieldMapping::IS_DELETED['no'])->first();
        if (!$updateData) {
            return $this->toJson('没有找到要更新的数据');
        }

        //验证名字是否重复
        $old = FieldMapping::query()->where([
            'is_deleted' => FieldMapping::IS_DELETED['no'],
            'project_id' => $updateData->project_id,
            'field' => $data['field']
        ])->first();
        if ($old) {
            return $this->failedToJson('字段名不能重复');
        }

        $updateData->field = $data['field'];
        $updateData->type = $data['type'];
        $updateData->description = $data['description'];
        if ($updateData->save()) {
            return $this->toJson();
        }

        return $this->failedToJson();
    }

    /**
     * 删除映射
     * @RequestMapping(path="del",methods="post")
     */
    public function delete()
    {
        $validator = $this->validationFactory->make($this->request->post(), [
            'id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return $this->failedToJson($validator->errors()->first());
        }
        $data = $validator->validated();
        $data = FieldMapping::query()->find($data['id']);
        if (!$data) {
            return $this->failedToJson('没有找到要删除的数据');
        }

        $data->is_deleted = FieldMapping::IS_DELETED['yes'];
        if ($data->save()) {
            return $this->toJson();
        }

        $this->failedToJson('删除失败');
    }
}
