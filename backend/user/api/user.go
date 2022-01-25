package api

import (
	"fastduck/apidoc/user/global"
	"fastduck/apidoc/user/request"
	"fastduck/apidoc/user/response"
	"fastduck/apidoc/user/service"

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

	if u, ok := service.UserRegister(reg); ok != nil {
		response.FailWithMessage(ok.Error(), c)
	} else {
		response.OkWithData(u, c)
	}
}

//UserLogin 用户登录，账号字段支持填入账号和邮箱，因为都是唯一的
func UserLogin(c *gin.Context) {
	var login request.UserLoginRequest
	err := c.ShouldBindJSON(&login)
	if err != nil {
		response.FailWithMessage(global.ErrResp(err), c)
		return
	}

	if u, ok := service.UserLogin(login, c.ClientIP()); ok != nil {
		response.FailWithMessage(ok.Error(), c)
	} else {
		response.OkWithData(u, c)
	}
}

//UserLogout 用户退出登陆
func UserLogout(c *gin.Context) {
	var loginOut request.UserLogoutRequest
	err := c.ShouldBindJSON(&loginOut)
	if err != nil {
		response.FailWithMessage(global.ErrResp(err), c)
		return
	}

	if err := service.UserLogout(loginOut.UserId); err != nil {
		response.FailWithMessage(err.Error(), c)
		return
	}

	response.Ok(c)
}

//UserProfileUpdate 更新用户个人资料
func UserProfileUpdate(c *gin.Context) {
	var profile request.UserProfileUpdateRequest
	if err := c.ShouldBindJSON(&profile); err != nil {
		response.FailWithMessage(global.ErrResp(err), c)
		return
	}

	if _, err := service.UserProfileUpdate(profile); err != nil {
		response.FailWithMessage(err.Error(), c)
		return
	} else {
		response.Ok(c)
	}

}
