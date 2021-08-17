package api

import (
	"fastduck/apidoc/request"
	"fastduck/apidoc/response"
	"fastduck/apidoc/service"

	"github.com/gin-gonic/gin"
)

//UserRegister 用户注册
func UserRegister(c *gin.Context) {

	var reg request.UserRegisterRequest
	err := c.ShouldBindJSON(&reg)
	if err != nil {
		response.FailWithMessage(err.Error(), c)
		return
	}

	if ok, u := service.UserRegister(reg); ok != nil {
		response.FailWithMessage(ok.Error(), c)
	} else {
		response.OkWithData(u, c)
	}

}
