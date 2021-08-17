package request

type UserRegisterRequest struct {
	Pwd     string `json:"pwd"`
	RePwd   string `json:"rePwd"`
	Account string `json:"account"`
	Email   string `json:"email"`
	Code    string `json:"code"`
}
