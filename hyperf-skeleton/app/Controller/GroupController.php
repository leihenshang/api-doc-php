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
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

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
        $group = Group::query()->where(['project_id' => $reqData['projectId'], 'type' => $reqData['type']])->get();
        return Helper::success($group);
    }
}
