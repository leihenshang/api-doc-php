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
use App\Model\Group;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use App\Middleware\Auth\AuthMiddleware;

/**
 * @Controller()
 * Class GroupController
 * @package App\Controller
 */
class GroupController extends AbstractController
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
                'projectId' => 'required',
                'type' => 'required',
                'ps' => 'integer',
                'cp' => 'integer',
            ]
        );

        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            return Helper::failed($errorMessage);
        }
        $reqData = $validator->validated();
        $group = Group::query()->where([
            'project_id' => $reqData['projectId'],
            'type' => $reqData['type'],
            'is_deleted' => Group::IS_DELETED['no']
        ])->get();
        return Helper::success($group);
    }

    /**
     * 创建分组
     * @RequestMapping(path="create",methods="post")
     * @Middleware(AuthMiddleware::class)
     */
    public function create()
    {
        $validator = $this->validationFactory->make(
            $this->request->all(),
            [
                'projectId' => 'required',
                'type' => 'required',
                'title' => 'required',
            ]
        );

        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            return Helper::failed($errorMessage);
        }

        $data = $validator->validated();

        //检查同一分组，统一类型，title不能重复
        $oldGroup = Group::query()->where([
            'title' => $data['title'],
            'type' => $data['type'],
            'project_id' => $data['projectId'],
        ])->where('is_deleted', Group::IS_DELETED['no'])->first();
        if ($oldGroup) {
            return $this->failedToJson('分组名重复');
        }

        $group = new Group();
        $group->project_id = $data['projectId'];
        $group->type = $data['type'];
        $group->title = $data['title'];
        if ($group->save()) {
            return $this->toJson();
        }

        return $this->failedToJson();
    }

    /**
     * 更新分组名
     * @RequestMapping(path="update",methods="post")
     */
    public function update()
    {
        $validate = $this->validationFactory->make($this->request->post(), [
            'id' => 'required|numeric',
            'title' => 'required|string|between:1,100'
        ]);

        if ($validate->fails()) {
            $errorMessage = $validate->errors()->first();
            return Helper::failed($errorMessage);
        }

        $data = $validate->validated();
        $group = Group::query()->where('id', $data['id'])->where('is_deleted', Group::IS_DELETED['no'])->first();
        if (!$group) {
            return $this->toJson('没有找到要更新的数据');
        }

        //验证名字是否重复
        $oldGroup = Group::query()->where([
            'is_deleted' => Group::IS_DELETED['no'],
            'type' => $group->type,
            'project_id' => $group->project_id,
            'title' => $data['title']
        ])->first();
        if ($oldGroup) {
            return $this->failedToJson('组名不能重复');
        }

        $group->title = $data['title'];
        if ($group->save()) {
            return $this->toJson();
        }

        return $this->failedToJson();
    }

    /**
     * 删除分组
     * @RequestMapping(path="del",methods="post")
     */
    public function del()
    {
        $validator = $this->validationFactory->make($this->request->post(), [
            'id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return $this->failedToJson($validator->errors()->first());
        }
        $data = $validator->validated();
        $group = Group::query()->find($data['id']);
        if (!$group) {
            return $this->failedToJson('没有找到要删除的数据');
        }

        $group->is_deleted = Group::IS_DELETED['yes'];
        if ($group->save()) {
            return $this->toJson();
        }

        $this->failedToJson('删除失败');
    }
}
