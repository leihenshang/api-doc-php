package service

import (
	"errors"
	"fastduck/apidoc/global"
	"fastduck/apidoc/model"
	"fastduck/apidoc/request"
	"fastduck/apidoc/utils"
	"fmt"
	"regexp"
	"time"

	"go.uber.org/zap"
	"gorm.io/gorm"
)

//UserRegister 用户注册
func UserRegister(r request.UserRegisterRequest) (u model.User, err error) {

	pwd, err := checkPasswordRule(r.Password, r.RePassword)
	if err != nil {
		return u, err
	}

	//对密码进行加密
	encryptedPwd, err := utils.PasswordEncrypt(pwd)
	if err != nil {
		return u, errors.New("加密密码失败")
	}

	//检查账号格式
	if err := checkAccountRule(r.Account, 8); err != nil {
		return u, err
	}

	//检查账号是否重复
	if checkAccountIsDuplicate(r.Account) {
		return u, errors.New("账号重复")
	}

	//检查邮箱是否重复
	if checkEmailIsDuplicate(r.Email) {
		return u, errors.New("邮箱重复")
	}

	if u.Nickname == "" {
		u.Nickname = r.Account
	}

	u.Account = r.Account
	u.Email = r.Email
	u.Password = encryptedPwd
	err = global.DB.Create(&u).Error
	//返回数据不显示密码
	u.Password = ""
	return u, err
}

//checkAccountIsDuplicate 检查账号是否重复
func checkAccountIsDuplicate(account string) bool {
	var user *model.User
	result := global.DB.Where("account = ?", account).First(&user)
	if result.RowsAffected > 0 {
		return true
	}

	return false
}

//checkAccountRule 检查账号规则
func checkAccountRule(account string, accountLen int) (err error) {
	if accountLen == 0 {
		global.ZAPSUGAR.Fatal("accountLen is zero.")
		return errors.New("accountLen 设置错误")
	}

	if len(account) < accountLen {
		return errors.New(fmt.Sprintf("账号长度不能小于%d", accountLen))
	}

	//需要检查一下账号只能使用英文和数字
	reg := regexp.MustCompile(`^[a-zA-Z\d]*$`)
	if isAccord := reg.MatchString(account); !isAccord {
		return errors.New("账号必须为数字或英文")
	}

	return
}

//checkEmailIsDuplicate 检查邮箱是否重复
func checkEmailIsDuplicate(email string) bool {
	var user *model.User
	result := global.DB.Where("email = ?", email).First(&user)
	if result.RowsAffected > 0 {
		return true
	}

	return false
}

//checkPasswordRule 检查密码规则是否符合规则
func checkPasswordRule(password string, repeatPassword string) (string, error) {
	if len(password) < 8 {
		return "", errors.New("密码长度不能低于8位")
	}

	if password != repeatPassword {
		return "", errors.New("两次输入的密码不一致")
	}

	return password, nil
}

//UserLogin 用户登录
func UserLogin(r request.UserLoginRequest, clientIp string) (u model.User, err error) {
	if len(r.Password) == 0 || len(r.Account) == 0 {
		return u, errors.New("密码或账号(邮箱)不能为空")
	}

	result := global.DB.Where("account = ? OR email = ?", r.Account, r.Account).First(&u)
	if result.RowsAffected <= 0 {
		return u, errors.New(fmt.Sprintf("账号或登录邮箱: %s 没有找到", r.Account))
	}

	//检查账号状态
	if u.UserStatus != model.UserStatusAvaliable {
		return u, errors.New("账号不可用或未激活")
	}

	if utils.PasswordCompare(u.Password, r.Password) == false {
		return u, errors.New("输入的密码不匹配")
	}

	//下发token以及设置token过期时间
	u.Token = utils.GenerateLoginToken(u.Id)
	tokenExpire := model.CustomTime(time.Now().Add(time.Hour * 36))
	u.TokenExpire = &tokenExpire

	//设置登录时间记录用户登录ip
	u.LastLoginIp = clientIp
	customTime := model.CustomTime(time.Now())
	u.LastLoginTime = &customTime
	if err := global.DB.Select("LastLoginIp", "LastLoginTime", "Token", "TokenExpire").Save(&u).Error; err != nil {
		return u, errors.New("登录失败: 更新登录状态发生错误")
	}

	//密码置空
	u.Password = ""
	return u, err
}

//UserLogout 用户退出登陆
func UserLogout(userId uint64) error {
	var user model.User
	if errors.Is(global.DB.Where("id = ?", userId).First(&user).Error, gorm.ErrRecordNotFound) {
		return nil
	}

	user.Token = ""
	user.TokenExpire = nil

	if err := global.DB.Save(&user).Error; err != nil {
		global.ZAP.Error("退出登陆，更新信息失败", zap.Any("dbErr", err))
		return errors.New("更新信息失败")
	}

	return nil
}

//UserProfileUpdate 更新用户个人资料
func UserProfileUpdate(profile request.UserProfileUpdateRequest) (u model.User, err error) {
	if errors.Is(global.DB.Where("id = ?", profile.UserId).First(&u).Error, gorm.ErrRecordNotFound) {
		return u, errors.New("用户没有找到")
	}

	if err := global.DB.Model(&u).
		Select("NickName", "IconPath", "Bio", "Mobile").
		Updates(model.User{
			Nickname: profile.NickName,
			Avatar:   profile.NickName,
			Bio:      profile.Bio,
			Mobile:   profile.Mobile,
		}).
		Error; err != nil {
		return u, errors.New("更新个人资料失败")
	}

	return u, nil
}
