<?php

$list = Db::name('sys_role_system_relation')->alias('r')
    ->join('sys_system s', 's.id=r.system_id')
    ->where(['role_id' => 1])->field('s.id,s.name')
    ->order('id')
    ->select();
$data = [];

function getMenu($system_id, $role_id, $parent_id = 0, $parent = [], &$data = [], &$level = 0)
{
    $list = Db::name('sys_menu')->alias('m')
        ->join('sys_role_menu_relation r', 'r.menu_id=m.id')
        ->where(['r.role_id' => $role_id])
        ->where(['system_id' => $system_id, 'parent_id' => $parent_id])
        ->field('m.*')
        ->select();
    if (!$list) {
        return [];
    }
    foreach ($list as $item) {
        $temp = array_merge($parent, [$item['name']]);
        $data[] = $temp;
        ++$level;
        getMenu($system_id, $role_id, $item['id'], $temp, $data, $level);
        $funcList = Db::name('sys_menu_func')->alias('f')
            ->join('sys_role_menu_func_relation r', 'r.menu_func_id=f.id')
            ->where(['r.role_id' => $role_id])
            ->where(['f.menu_id' => $item['id']])
            ->field('f.*')
            ->select();
        foreach ($funcList as $v) {
            $data[] = array_merge($temp, [$v['name']]);
        }
    }
    return $data;
}
$l = 0;
foreach ($list as $item) {
    $data[] = [$item['name']];
    $temp = [];
    $level = 0;
    $data = array_merge($data, getMenu(
        $item['id'],
        1,
        0,
        [$item['name']],
        $temp,
        $level
    ));
    $l = $level > $l ? $level : $l;
}
$title = ['系统'];
foreach (range(0, $l - 1) as $v) {
    $title[] = '菜单' . (string)($v + 1);
}
$data = array_merge([$title], $data);
//        return $this->success($data);
return $this->success(ExportExcel::createExcel($data));
