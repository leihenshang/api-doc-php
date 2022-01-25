package router

import (
	"fastduck/apidoc/user/api"
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
	{
		userRoute.POST("/reg", api.UserRegister)
		userRoute.POST("/login", api.UserLogin)
		userRoute.POST("/logout", api.UserLogout)
		userRoute.POST("/updateProfile", api.UserProfileUpdate)
	}

	//doc
	docRoute := r.Group("doc")
	{
		docRoute.POST("/create", api.DocCreate)
		docRoute.POST("/detail", api.DocDetail)
		docRoute.POST("/list", api.DocList)
		docRoute.POST("/update", api.DocUpdate)
		docRoute.POST("/delete", api.DocDelete)
	}

}
