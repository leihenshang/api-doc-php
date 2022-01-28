package router

import (
	"fastduck/apidoc/user/api"
	"fastduck/apidoc/user/middleware/auth"
	"net/http"

	"github.com/gin-gonic/gin"
)

func InitRoute(r *gin.Engine) {
	//测试连通性
	base := r.Group("/")
	{
		base.GET("/ping", func(c *gin.Context) {
			c.JSON(http.StatusOK, gin.H{
				"msg": "pong",
			})
		})
	}

	//user
	userRoute := r.Group("user")
	//不需要验证登录参数
	{
		userRoute.POST("/reg", api.UserRegister)
		userRoute.POST("/login", api.UserLogin)
	}
	//需要验证登录参数
	userRoute.Use(auth.Auth())
	{
		userRoute.POST("/logout", api.UserLogout)
		userRoute.POST("/updateProfile", api.UserProfileUpdate)
	}

	//doc
	docRoute := r.Group("doc").Use(auth.Auth())
	{
		docRoute.POST("/create", api.DocCreate)
		docRoute.POST("/detail", api.DocDetail)
		docRoute.POST("/list", api.DocList)
		docRoute.POST("/update", api.DocUpdate)
		docRoute.POST("/delete", api.DocDelete)
	}

}
