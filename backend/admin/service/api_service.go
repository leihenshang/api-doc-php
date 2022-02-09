package service

import (
	"fastduck/apidoc/admin/global"
	"fastduck/apidoc/admin/model"
)

//ApiList api列表
func ApiList(projectId int, page int, pageSize int, sortField string, isDesc bool) (total int64, list []model.API) {
	query := global.DB.Model(&model.API{}).Where("project_id = ?", projectId)
	query.Count(&total)
	offset := (page - 1) * pageSize
	query.Offset(offset).Limit(pageSize).Find(&list)
	return total, list
}

//ApiDetailById api详情
func ApiDetailById(id int) (a model.API) {
	global.DB.First(&a, id)
	return
}

//ApiDeleteById 删除api
func ApiDeleteById(id int) (ok bool) {
	var a model.API
	global.DB.First(&a, id)
	if a.ID <= 0 {
		return
	}

	global.DB.Delete(&a)
	return true
}
