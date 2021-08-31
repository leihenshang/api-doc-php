package router

import (
	"fastduck/apidoc/api"
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
		userRoute.POST("/register", api.UserRegister)
		userRoute.POST("/login", api.UserLogin)
		userRoute.POST("/logout", api.UserLogout)
		userRoute.POST("/create", api.Delete)
		userRoute.POST("/update", api.Update)
		userRoute.POST("/updateProfile", api.UserProfileUpdate)
		userRoute.GET("/list", api.Update)
		userRoute.GET("/detail", api.Update)
	}

	//api
	apiRoute := r.Group("api")
	{
		apiRoute.GET("/list", api.List)
		apiRoute.GET("/detail", api.DetailById)
		apiRoute.POST("/create", api.Create)
		apiRoute.POST("/delete", api.Delete)
		apiRoute.POST("/update", api.Update)
	}
}
