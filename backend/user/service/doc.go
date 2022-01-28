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

//DocCreate 创建文档
func DocCreate(r doc.CreateDocRequest, userId uint64) (d *model.Doc, err error) {
	insertData := &model.Doc{
		UserId:  userId,
		Title:   r.Title,
		Content: r.Content,
		GroupId: r.GroupId,
		IsTop:   r.IsTop,
	}

	if existed, checkErr := checkDocTitleRepeat(insertData.Title, userId); checkErr != nil {
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

//checkDocTitleRepeat 查询数据库检查文档标题是否重复
func checkDocTitleRepeat(title string, userId uint64) (doc *model.Doc, err error) {
	q := global.DB.Model(&model.Doc{}).Where("title = ? AND user_id = ?", title, userId)
	if err = q.First(&doc).Error; err != nil {
		if errors.Is(err, gorm.ErrRecordNotFound) {
			err = nil
		}
	}

	return
}

//DocDetail 文档详情
func DocDetail(r request.IdRequest, userId uint64) (d *model.Doc, err error) {
	q := global.DB.Model(&model.Doc{}).Where("id = ? AND user_id = ?", r.Id, userId)
	err = q.First(&d).Error
	return
}

//DocList 文档列表
func DocList(r request.ListRequest, userId uint64) (res response.ListResponse, err error) {
	offset := (r.Page - 1) * r.PageSize
	if offset < 0 {
		offset = 1
	}

	var list []model.Doc
	q := global.DB.Model(&model.Doc{}).Where("user_id = ?", userId)
	q.Count(&res.Total)
	err = q.
		Limit(r.PageSize).
		Offset(offset).
		Find(&list).
		Error
	res.List = list
	return
}

//DocUpdate 文档更新
func DocUpdate(r doc.UpdateDocRequest, userId uint64) (err error) {
	if r.Id <= 0 {
		errMsg := fmt.Sprintf("id 为 %d 的数据没有找到", r.Id)
		global.ZAPSUGAR.Error(errMsg)
		return errors.New(errMsg)
	}

	q := global.DB.Model(&model.Doc{}).Where("id = ? AND user_id = ?", r.Id, userId)
	u := map[string]interface{}{"Title": r.Title, "Content": r.Content, "GroupId": r.GroupId}
	if err = q.Updates(u).Error; err != nil {
		errMsg := fmt.Sprintf("修改id 为 %d 的数据失败 %v ", r.Id, err)
		global.ZAPSUGAR.Error(errMsg)
		return errors.New("操作失败")
	}

	return
}

//DocDelete 文档删除
func DocDelete(r doc.UpdateDocRequest, userId uint64) (err error) {
	if r.Id <= 0 {
		errMsg := fmt.Sprintf("id 为 %d 的数据没有找到", r.Id)
		global.ZAPSUGAR.Error(errMsg)
		return errors.New(errMsg)
	}

	q := global.DB.Where("id = ? AND user_id = ?", r.Id, userId)
	if err = q.Delete(&model.Doc{}).Error; err != nil {
		errMsg := fmt.Sprintf("删除id 为 %d 的数据失败 %v ", r.Id, err)
		global.ZAPSUGAR.Error(errMsg)
		return errors.New("操作失败")
	}

	return
}
