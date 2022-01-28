package service

import (
	"errors"
	"fastduck/apidoc/admin/response"
	"fastduck/apidoc/user/global"
	"fastduck/apidoc/user/model"
	"fastduck/apidoc/user/request"
	"fastduck/apidoc/user/request/doc"
	"fmt"

	"gorm.io/gorm"
)

//DocGroupCreate 创建文档分组
func DocGroupCreate(r doc.CreateDocGroupRequest, userId uint64) (dg *model.DocGroup, err error) {
	insertData := &model.DocGroup{
		Title:  r.Title,
		Icon:   r.Icon,
		PId:    uint64(r.PId),
		UserId: userId,
	}

	if existed, checkErr := checkDocGroupTitleRepeat(insertData.Title, userId); checkErr != nil {
		global.ZAPSUGAR.Error(r, userId, "检查文档分组标题失败")
		return nil, errors.New("检查文档分组标题失败")
	} else {
		fmt.Println(existed)
		if existed != nil {
			return nil, errors.New("文档分组标题已存在")
		}
	}

	if err = global.DB.Create(insertData).Error; err != nil {
		global.ZAPSUGAR.Error(r, err)
		return nil, errors.New("创建文档分组失败")
	}

	return
}

//checkDocGroupTitleRepeat 查询数据库检查文档分组标题是否重复
func checkDocGroupTitleRepeat(title string, userId uint64) (dg *model.DocGroup, err error) {
	q := global.DB.Model(&model.DocGroup{}).Where("title = ? AND user_id = ?", title, userId)
	if err = q.First(&dg).Error; err != nil {
		if errors.Is(err, gorm.ErrRecordNotFound) {
			return nil, nil
		}
	}

	return
}

//DocGroupList 文档分组列表
func DocGroupList(r request.ListRequest, userId uint64) (res response.ListResponse, err error) {
	offset := (r.Page - 1) * r.PageSize
	if offset < 0 {
		offset = 1
	}

	var list []model.DocGroup
	q := global.DB.Model(&model.DocGroup{}).Where("user_id = ?", userId)
	q.Count(&res.Total)
	err = q.
		Limit(r.PageSize).
		Offset(offset).
		Find(&list).
		Error
	res.List = list
	return
}

//DocGroupUpdate 文档分组更新
func DocGroupUpdate(r doc.UpdateDocGroupRequest, userId uint64) (err error) {
	if r.Id <= 0 {
		errMsg := fmt.Sprintf("id 为 %d 的数据没有找到", r.Id)
		global.ZAPSUGAR.Error(errMsg)
		return errors.New(errMsg)
	}

	q := global.DB.Model(&model.DocGroup{}).Where("id = ? AND user_id = ?", r.Id, userId)
	u := map[string]interface{}{"Title": r.Title, "PId": r.PId, "Icon": r.Icon}
	if err = q.Updates(u).Error; err != nil {
		errMsg := fmt.Sprintf("修改id 为 %d 的数据失败 %v ", r.Id, err)
		global.ZAPSUGAR.Error(errMsg)
		return errors.New("操作失败")
	}

	return
}

//DocGroupDelete 文档分组删除u
func DocGroupDelete(r doc.UpdateDocGroupRequest, userId uint64) (err error) {
	if r.Id <= 0 {
		errMsg := fmt.Sprintf("id 为 %d 的数据没有找到", r.Id)
		global.ZAPSUGAR.Error(errMsg)
		return errors.New(errMsg)
	}

	q := global.DB.Where("id = ? AND user_id = ?", r.Id, userId)
	if err = q.Delete(&model.DocGroup{}).Error; err != nil {
		errMsg := fmt.Sprintf("删除id 为 %d 的数据失败 %v ", r.Id, err)
		global.ZAPSUGAR.Error(errMsg)
		return errors.New("操作失败")
	}

	return
}
