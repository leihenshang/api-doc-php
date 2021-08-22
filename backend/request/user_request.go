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
	Password   string `json:"password"`
	Account    string `json:"account"`
	VerifyCode string `json:"verifyCode"`
}
