package model

import (
	"time"
)

// User 用户表
type User struct {
	BasicModel
	NickName      string    `gorm:"column:nick_name;type:varchar(100)" json:"nickName"`                                 // 展示昵称可以更改
	Account       string    `gorm:"uniqueIndex:user_info_UN1;column:account;type:varchar(100);not null" json:"account"` // 登录账号名不可更改
	Email         string    `gorm:"uniqueIndex:user_info_UN1;column:email;type:varchar(100)" json:"email"`              // 邮箱
	Password      string    `gorm:"column:password;type:varchar(100);not null" json:"password"`                         // 密码
	UserType      uint8     `gorm:"column:user_type;type:tinyint(3) unsigned;not null;default:3" json:"userType"`       // 用户类型1超级管理员2管理员3用户
	Status        uint8     `gorm:"column:status;type:tinyint(3) unsigned;not null;default:1" json:"status"`            // 1正常2禁用
	IsActivated   uint8     `gorm:"column:is_activated;type:tinyint(3) unsigned;not null;default:1" json:"isActivated"` // 是否激活,1-已激活,2-未激活
	Mobile        string    `gorm:"column:mobile;type:char(11)" json:"mobile"`                                          // 手机号
	Avatar        string    `gorm:"column:avatar;type:varchar(100)" json:"avatar"`                                      // 头像
	Description   string    `gorm:"column:description;type:varchar(200);not null;default:无" json:"description"`         // 自我说明
	Token         string    `gorm:"column:token;type:varchar(100)" json:"token"`                                        // 访问token
	TokenExpire   time.Time `gorm:"column:token_expire;type:datetime" json:"tokenExpire"`                               // token过期时间
	LastLoginIP   string    `gorm:"column:last_login_ip;type:varchar(100)" json:"lastLoginIp"`                          // 最后登陆ip
	LastLoginTime time.Time `gorm:"column:last_login_time;type:datetime" json:"lastLoginTime"`
}

// TableName get sql table name.获取数据库表名
func (m *User) TableName() string {
	return "user"
}

// UserColumns get sql column name.获取数据库列名
var UserColumns = struct {
	ID            string
	NickName      string
	Account       string
	Email         string
	Password      string
	UserType      string
	Status        string
	IsActivated   string
	Mobile        string
	Avatar        string
	Description   string
	Token         string
	TokenExpire   string
	LastLoginIP   string
	LastLoginTime string
	CreateTime    string
	DeleteTime    string
	UpdateTime    string
}{
	ID:            "id",
	NickName:      "nick_name",
	Account:       "account",
	Email:         "email",
	Password:      "password",
	UserType:      "user_type",
	Status:        "status",
	IsActivated:   "is_activated",
	Mobile:        "mobile",
	Avatar:        "avatar",
	Description:   "description",
	Token:         "token",
	TokenExpire:   "token_expire",
	LastLoginIP:   "last_login_ip",
	LastLoginTime: "last_login_time",
	CreateTime:    "create_time",
	DeleteTime:    "delete_time",
	UpdateTime:    "update_time",
}
