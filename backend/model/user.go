package model

//1-可用,2-不可用,3-未激活
const UserStatusAvaliable = 1
const UserStatusInvalid = 2
const UserStatusNotActivated = 3

// User 用户表
type User struct {
	BasicModel
	Nickname      string      `gorm:"column:nickname;type:varchar(50);NOT NULL;comment:昵称;AUTO_INCREMENT"`
	Account       string      `gorm:"column:account;type:varchar(100);NOT NULL;comment:账号"`
	Email         string      `gorm:"column:email;type:varchar(100);comment:邮箱"`
	Password      string      `gorm:"column:password;type:varchar(100);NOT NULL;comment:密码';"`
	UserType      uint        `gorm:"column:user_type;type:tinyint(3) unsigned;default:1;NOT NULL;comment:1-普通用户,2管理员,100超级管理员"`
	Status        uint        `gorm:"column:status;type:tinyint(3) unsigned;default:1;NOT NULL;comment:1-可用,2-不可用,3-未激活"`
	Mobile        string      `gorm:"column:mobile;type:char(11);comment:手机号"`
	IconPath      string      `gorm:"column:icon_path;type:varchar(100);comment:头像地址"`
	Bio           string      `gorm:"column:bio;type:varchar(200);comment:个人说明"`
	Token         string      `gorm:"column:token;type:varchar(100);comment:登陆token"`
	TokenExpire   *CustomTime `gorm:"column:token_expire;type:datetime;comment:token超时时间"`
	LastLoginIp   string      `gorm:"column:last_login_ip;type:varchar(100);comment:最后登陆ip地址"`
	LastLoginTime *CustomTime `gorm:"column:last_login_time;type:datetime;comment:最后登陆时间"`
}

func (m *User) TableName() string {
	return "user"
}
