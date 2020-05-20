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

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use League\Flysystem\Filesystem;
use Hyperf\Di\Annotation\Inject;
use Throwable;

/**
 * @Controller()
 * Class FileController
 * @package App\Controller
 */
class FileController extends AbstractController
{

    /**
     * @Inject()
     * @var ValidatorFactoryInterface
     */
    protected $validationFactory;

    /**
     * @RequestMapping(path="index",methods="get,post")
     * @param Filesystem $filesystem
     * @return mixed
     */
    public function index(Filesystem $filesystem)
    {
        $file = $this->request->file('upload');
        if (!$file->isFile()) {
            return $this->failedToJson('请选择文件');
        }

        $validator = $this->validationFactory->make(
            ['upload' => $file],
            [
                'upload' => 'required|image|min:1|max:5000000',
            ]
        );

        if ($validator->fails()) {
            // Handle exception
            $errorMessage = $validator->errors()->first();
            return $this->failedToJson($errorMessage);
        }

        $path = config('server.settings.document_root', '');
        if (!is_dir($path)) {
            return $this->failedToJson('获取目录失败');
        }

        $savePath = $path . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . $file->getClientFilename();
        $relativePath = 'upload' . DIRECTORY_SEPARATOR . $file->getClientFilename();

        if (file_exists($savePath)) {
            return $this->toJson([
                'path' => $relativePath
            ]);
        }


        $stream = fopen($file->getRealPath(), 'r+');
        try {
            $filesystem->writeStream(
                $relativePath,
                $stream
            );
        } catch (Throwable $e) {
            return $this->failedToJson('上传失败' . $e->getMessage());
        }


        fclose($stream);
        return $this->toJson([
            'path' => $relativePath
        ]);
    }
}
