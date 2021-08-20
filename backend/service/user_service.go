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

	u.Nickname = ""
	u.Account = r.Account
	u.Email = r.Email
	u.Password = r.Password
	err = global.DB.Debug().Create(&u).Error
	return err, u
}
