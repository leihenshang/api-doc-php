package service

import (
	"errors"
	"fastduck/apidoc/admin/response"
	"fastduck/apidoc/user/global"
	"fastduck/apidoc/user/model"
	"fastduck/apidoc/user/request"
	"fastduck/apidoc/user/request/team"
	"fmt"

	"gorm.io/gorm"
)

//TeamCreate 创建文档
func TeamCreate(r team.CreateOrUpdateTeamRequest, userId uint64) (d *model.Team, err error) {
	insertData := &model.Team{}

	if existed, checkErr := checkTeamTitleRepeat(insertData.Name, userId); checkErr != nil {
		global.ZAPSUGAR.Error(r, userId, "检查文档标题失败")
		return nil, errors.New("检查文档标题失败")
	} else {
		if existed != nil {
			return nil, errors.New("文档标题已存在")
		}
	}

	if err = global.DB.Create(insertData).Error; err != nil {
		global.ZAPSUGAR.Error(r, err)
		return nil, errors.New("创建文档失败")
	}

	return
}

//checkTeamTitleRepeat 查询数据库检查文档标题是否重复
func checkTeamTitleRepeat(title string, userId uint64) (team *model.Team, err error) {
	q := global.DB.Model(&model.Team{}).Where("title = ? AND user_id = ?", title, userId)
	if err = q.First(&team).Error; err != nil {
		if errors.Is(err, gorm.ErrRecordNotFound) {
			return nil, nil
		}
	}

	return
}

//TeamDetail 文档详情
func TeamDetail(r request.IdRequest, userId uint64) (d *model.Team, err error) {
	q := global.DB.Model(&model.Team{}).Where("id = ? AND user_id = ?", r.Id, userId)
	err = q.First(&d).Error
	return
}

//TeamList 文档列表
func TeamList(r request.ListRequest, userId uint64) (res response.ListResponse, err error) {
	offset := (r.Page - 1) * r.PageSize
	if offset < 0 {
		offset = 1
	}

	var list []model.Team
	q := global.DB.Model(&model.Team{}).Where("user_id = ?", userId)
	q.Count(&res.Total)
	err = q.
		Limit(r.PageSize).
		Offset(offset).
		Find(&list).
		Error
	res.List = list
	return
}

//TeamUpdate 文档更新
func TeamUpdate(r team.CreateOrUpdateTeamRequest, userId uint64) (err error) {
	if r.Id <= 0 {
		errMsg := fmt.Sprintf("id 为 %d 的数据没有找到", r.Id)
		global.ZAPSUGAR.Error(errMsg)
		return errors.New(errMsg)
	}

	q := global.DB.Model(&model.Team{}).Where("id = ? AND user_id = ?", r.Id, userId)
	u := map[string]interface{}{"Name": r.Name}
	if err = q.Updates(u).Error; err != nil {
		errMsg := fmt.Sprintf("修改id 为 %d 的数据失败 %v ", r.Id, err)
		global.ZAPSUGAR.Error(errMsg)
		return errors.New("操作失败")
	}

	return
}

//TeamDelete 文档删除
func TeamDelete(r team.CreateOrUpdateTeamRequest, userId uint64) (err error) {
	if r.Id <= 0 {
		errMsg := fmt.Sprintf("id 为 %d 的数据没有找到", r.Id)
		global.ZAPSUGAR.Error(errMsg)
		return errors.New(errMsg)
	}

	q := global.DB.Where("id = ? AND user_id = ?", r.Id, userId)
	if err = q.Delete(&model.Team{}).Error; err != nil {
		errMsg := fmt.Sprintf("删除id 为 %d 的数据失败 %v ", r.Id, err)
		global.ZAPSUGAR.Error(errMsg)
		return errors.New("操作失败")
	}

	return
}
