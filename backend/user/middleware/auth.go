package middleware

import (
	"fastduck/apidoc/user/global"
	"fastduck/apidoc/user/service"
	"net/http"

	"github.com/gin-gonic/gin"
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
