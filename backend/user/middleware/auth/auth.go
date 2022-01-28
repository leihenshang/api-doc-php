package auth

import (
	"errors"
	"fastduck/apidoc/user/global"
	"fastduck/apidoc/user/model"
	"fastduck/apidoc/user/service"
	"net/http"

	"github.com/gin-gonic/gin"
)

const (
	UserInfoKey = "userinfo"
)

//Auth 身份验证
func Auth() gin.HandlerFunc {
	return func(c *gin.Context) {
		xToken := c.GetHeader("X-Token")
		if xToken == "" {
			c.AbortWithStatusJSON(http.StatusUnauthorized, "参数错误")
			return
		}

		u, err := service.GetUserByToken(xToken)
		if err != nil {
			global.ZAPSUGAR.Error(err)
			c.AbortWithStatusJSON(http.StatusUnauthorized, "查询用户信息失败")
			return
		}
		if u == nil {
			global.ZAPSUGAR.Error("获取用户信息失败")
			c.AbortWithStatusJSON(http.StatusUnauthorized, "没有找到用户信息")
			return
		}

		//把用户信息写入 context
		c.Set("userinfo", u)

		c.Next()
	}

}

func userAccessParamsCheck(c *gin.Context) {

}

//GetUserInfoByCtx 从上下文获取用户信息
func GetUserInfoByCtx(c *gin.Context) (u *model.User, err error) {
	if v, exists := c.Get(UserInfoKey); !exists {
		return nil, errors.New("从上下文中获取用户信息失败")
	} else {
		if u, ok := v.(*model.User); ok {
			return u, nil
		}
	}

	return nil, errors.New("从上下文解析用户信息失败")
}
