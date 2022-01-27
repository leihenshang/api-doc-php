package api

import (
	"fastduck/apidoc/user/request"
	"fastduck/apidoc/user/request/doc"
	"fastduck/apidoc/user/response"
	"fastduck/apidoc/user/service"

	"github.com/gin-gonic/gin"
)

//DocCreate 创建文档
func DocCreate(c *gin.Context) {
	var req doc.CreateRequest
	err := c.ShouldBindJSON(&req)
	if err != nil {
		response.FailWithMessage(err.Error(), c)
		return
	}
	var userId uint64 = 0
	if d, ok := service.DocCreate(req, userId); ok != nil {
		response.FailWithMessage(ok.Error(), c)
	} else {
		response.OkWithData(d, c)
	}
}

//DocDetail 文档详情
func DocDetail(c *gin.Context) {
	req := request.IdRequest{}
	err := c.ShouldBindJSON(&req)
	if err != nil {
		response.FailWithMessage(err.Error(), c)
		return
	}
	var userId uint64 = 0
	if d, ok := service.DocDetail(req, userId); ok != nil {
		response.FailWithMessage(ok.Error(), c)
	} else {
		response.OkWithData(d, c)
	}

}

//DocList 文档列表
func DocList(c *gin.Context) {
	var req request.ListRequest
	if err := c.ShouldBindJSON(&req); err != nil {
		response.FailWithMessage(err.Error(), c)
		return
	}

	var userId uint64 = 0
	if d, ok := service.DocList(req, userId); ok != nil {
		response.FailWithMessage(ok.Error(), c)
	} else {
		response.OkWithData(d, c)
	}
}

//DocUpdate 文档更新
func DocUpdate(c *gin.Context) {
	var req doc.UpdateRequest
	if err := c.ShouldBindJSON(&req); err != nil {
		response.FailWithMessage(err.Error(), c)
		return
	}

	var userId uint64 = 0
	if ok := service.DocUpdate(req, userId); ok != nil {
		response.FailWithMessage(ok.Error(), c)
	} else {
		response.Ok(c)
	}
}

//DocDelete 文档删除
func DocDelete(c *gin.Context) {
	var req doc.UpdateRequest
	if err := c.ShouldBindJSON(&req); err != nil {
		response.FailWithMessage(err.Error(), c)
		return
	}

	var userId uint64 = 0
	if ok := service.DocDelete(req, userId); ok != nil {
		response.FailWithMessage(ok.Error(), c)
	} else {
		response.Ok(c)
	}
}
