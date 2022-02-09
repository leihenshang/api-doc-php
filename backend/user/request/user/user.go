package user

//UserRegisterRequest 用户注册请求
type UserRegisterRequest struct {
	Password   string `json:"password"`
	RePassword string `json:"rePassword"`
	Account    string `json:"account"`
	Email      string `json:"email"`
	Code       string `json:"code"`
}

//UserLoginRequest 用户登录请求
type UserLoginRequest struct {
	Password   string `json:"password" binding:"required,min=6,max=100"`
	Account    string `json:"account" binding:"required,min=6,max=100"`
	VerifyCode string `json:"verifyCode" binding:"required,min=4,max=100"`
}

//UserProfileUpdateRequest 个人资料更新
type UserProfileUpdateRequest struct {
	NickName string `json:"nickName" binding:"max=40"`
	IconPath string `json:"iconPath" binding:"max=100"`
	Bio      string `json:"bio" binding:"max=200"`
	Mobile   string `json:"mobile" binding:"len=11"`
}
