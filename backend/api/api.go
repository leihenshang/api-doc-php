package api

import (
	"fastduck/apidoc/request"
	"fastduck/apidoc/response"
	"fastduck/apidoc/service"

	"github.com/gin-gonic/gin"
)

// List  api列表
func List(c *gin.Context) {
	var req request.ApiListRequest
	err := c.ShouldBindQuery(&req)
	if err != nil {
		response.FailWithMessage(err.Error(), c)
	}

	total, list := service.ApiList(req.ProjectId, req.Page, req.PageSize, req.SortField, req.IsDesc)
	response.OkWithData(response.ListResponse{Total: total, List: list}, c)
}

// DetailById  api详情
func DetailById(c *gin.Context) {
	var req request.IdRequest
	err := c.ShouldBindQuery(&req)
	if err != nil {
		response.FailWithMessage(err.Error(), c)
	}

	a := service.ApiDetailById(req.Id)
	response.OkWithData(a, c)
}

// Delete  删除api
func Delete(c *gin.Context) {
	var req request.IdRequest
	err := c.ShouldBindJSON(&req)
	if err != nil {
		response.FailWithMessage(err.Error(), c)
	}

	a := service.ApiDetailById(req.Id)
	response.OkWithData(a, c)
}

//Create 创建api
func Create(c *gin.Context) {

}

//Update 更新api
func Update(c *gin.Context) {

}
