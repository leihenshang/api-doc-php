package service

import (
	"errors"
	"fastduck/apidoc/global"
	"fastduck/apidoc/model"
	"fastduck/apidoc/request"
)

//UserRegister 用户注册
func UserRegister(r request.UserRegisterRequest) (err error, u model.User) {
	if r.Password != r.RepeatPassword {
		return errors.New("两次输入的密码不一致"), u
	}

	//检查账号是否重复
	if checkAccountIsDuplicate(r.Account) {
		return errors.New("账号重复"), u
	}

	if u.Nickname == "" {
		u.Nickname = r.Account
	}

	u.Account = r.Account
	u.Email = r.Email
	u.Password = r.Password
	err = global.DB.Create(&u).Error
	return err, u
}

//checkAccountIsDuplicate 检查账号是否重复
func checkAccountIsDuplicate(account string) bool {

	return false
}
