package request

//UserRegisterRequest 用户注册请求
type UserRegisterRequest struct {
	Password       string `json:"password"`
	RepeatPassword string `json:"repeatPassword"`
	Account        string `json:"account"`
	Email          string `json:"email"`
	Code           string `json:"code"`
}

//UserLoginRequest 用户登录请求
type UserLoginRequest struct {
	Password   string `json:"password" binding:"required,min=6,max=100"`
	Account    string `json:"account" binding:"required,min=6,max=100"`
	VerifyCode string `json:"verifyCode" binding:"required,min=4,max=100"`
}
