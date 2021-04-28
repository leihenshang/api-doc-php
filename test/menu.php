<?php

$menu = [
    ['id' => 1, 'name' => 'menu1', 'pid' => 0],
    ['id' => 2, 'name' => 'menu2', 'pid' => 0],
    ['id' => 3, 'name' => 'menu3', 'pid' => 0],
    ['id' => 4, 'name' => 'menu4', 'pid' => 1],
    ['id' => 5, 'name' => 'menu5', 'pid' => 1],
    ['id' => 6, 'name' => 'menu6', 'pid' => 1],
    ['id' => 7, 'name' => 'menu7', 'pid' => 4],
    ['id' => 8, 'name' => 'menu8', 'pid' => 4],
    ['id' => 9, 'name' => 'menu9', 'pid' => 4],
    ['id' => 10, 'name' => 'menu10', 'pid' => 7],
    ['id' => 11, 'name' => 'menu11', 'pid' => 8],
    ['id' => 12, 'name' => 'menu12', 'pid' => 7],
    ['id' => 13, 'name' => 'menu13', 'pid' => 7],
    ['id' => 14, 'name' => 'menu14', 'pid' => 8],
    ['id' => 15, 'name' => 'menu15', 'pid' => 8],
];

function tree(array $data, array &$res, int $start = 0, int &$level = 1,  $parent = []): array
{
    $list = getChild($data, $start);
    $lev = 1;
    foreach ($list as  $item) {
        $temp = array_merge($parent, [$item['name']]);
        $lev = count($temp);
        $res[] = $temp;
        if ($lev > $level) {
            $level = $lev;
        }
        tree($data, $res, $item['id'], $level, $temp);
    }

    return $res;
}

function getChild($data, $pid)
{
    $res = [];
    foreach ($data as $value) {
        if ($value['pid'] == $pid) {
            $res[] = $value;
        }
    }
    return $res;
}

$level = 1;
$resArr = [];
$res = tree($menu, $resArr, 0,  $level);

header("Content-Type:application/json");
echo json_encode(["level" => $level, "res" => $resArr], JSON_UNESCAPED_UNICODE);
