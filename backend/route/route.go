package route

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
		userRoute.POST("/login", api.ApiDetailById)
		userRoute.POST("/logout", api.ApiCreate)
		userRoute.POST("/create", api.ApiDelete)
		userRoute.POST("/update", api.ApiUpdate)
		userRoute.GET("/list", api.ApiUpdate)
		userRoute.GET("/detail", api.ApiUpdate)
	}

	//api
	apiRoute := r.Group("api")
	{
		apiRoute.GET("/list", api.ApiList)
		apiRoute.GET("/detail", api.ApiDetailById)
		apiRoute.POST("/create", api.ApiCreate)
		apiRoute.POST("/delete", api.ApiDelete)
		apiRoute.POST("/update", api.ApiUpdate)
	}
}
