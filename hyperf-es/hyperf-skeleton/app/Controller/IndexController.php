<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use App\Model\Goods;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Elasticsearch\ClientBuilderFactory;

/**
 * @AutoController()
 */
class IndexController extends AbstractController
{
    public function index()
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();

        return [
            'method' => $method,
            'message' => "Hello1 {$user}.",
        ];
    }

    public function goodsList()
    {
        $query =  Goods::query();
        $count = $query->count();
        $res = $query->limit(20)->get();

        foreach ($res as  $value) {
            $params['body'][] = [
                'index' => [
                    '_index' => 'mygoods',
                    // '_type' => 'drug',
                    '_id' => $value['id']
                ]
            ];
        
            $params['body'][] = $value;
        }

        // $this->getEsClient()->bulk($params);

        return [
            'total' => $count,
            'list' => $res
        ];
    }

    private function getEsClient()
    {
        $bulid = $this->container->get(ClientBuilderFactory::class)->create();
        $client = $bulid->setHosts(['http://elastic:Es@123456789@es-cn-n6w24ipvx008l0cky.public.elasticsearch.aliyuncs.com:9200'])->build();
        return $client;
    }

    public function esQuery()
    {

        $name = $this->request->input('name');
        if(empty($name)) {
            return 'name不能为空';
        }

        $params['index'] = 'mygoods';
        $params['body'] = [
            'query' => [
                'match' => [
                    'name' => $name
                ]
            ]
        ];
     
        $results = $this->getEsClient()->search($params);

        return $results;
    }

    public function esTest()
    {
        $params = [
            'index' => 'reuters',
            'body' => [
                'settings' => [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 0,
                    'analysis' => [
                        'filter' => [
                            'shingle' => [
                                'type' => 'shingle'
                            ]
                        ],
                        'char_filter' => [
                            'pre_negs' => [
                                'type' => 'pattern_replace',
                                'pattern' => '(\\w+)\\s+((?i:never|no|nothing|nowhere|noone|none|not|havent|hasnt|hadnt|cant|couldnt|shouldnt|wont|wouldnt|dont|doesnt|didnt|isnt|arent|aint))\\b',
                                'replacement' => '~$1 $2'
                            ],
                            'post_negs' => [
                                'type' => 'pattern_replace',
                                'pattern' => '\\b((?i:never|no|nothing|nowhere|noone|none|not|havent|hasnt|hadnt|cant|couldnt|shouldnt|wont|wouldnt|dont|doesnt|didnt|isnt|arent|aint))\\s+(\\w+)',
                                'replacement' => '$1 ~$2'
                            ]
                        ],
                        'analyzer' => [
                            'reuters' => [
                                'type' => 'custom',
                                'tokenizer' => 'standard',
                                'filter' => ['lowercase', 'stop', 'kstem']
                            ]
                        ]
                    ]
                ],
                'mappings' => [
                    '_default_' => [
                        'properties' => [
                            'title' => [
                                'type' => 'string',
                                'analyzer' => 'reuters',
                                'term_vector' => 'yes',
                                'copy_to' => 'combined'
                            ],
                            'body' => [
                                'type' => 'string',
                                'analyzer' => 'reuters',
                                'term_vector' => 'yes',
                                'copy_to' => 'combined'
                            ],
                            'combined' => [
                                'type' => 'string',
                                'analyzer' => 'reuters',
                                'term_vector' => 'yes'
                            ],
                            'topics' => [
                                'type' => 'string',
                                'index' => 'not_analyzed'
                            ],
                            'places' => [
                                'type' => 'string',
                                'index' => 'not_analyzed'
                            ]
                        ]
                    ],
                    'my_type' => [
                        'properties' => [
                            'my_field' => [
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $this->getEsClient()->indices()->create($params);
    }

    
}
