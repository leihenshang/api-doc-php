package model

import (
	"time"
)

// User 用户表

type User struct {
	Id            uint64    `gorm:"column:id;type:bigint(20) unsigned;primary_key;AUTO_INCREMENT"`
	Nickname      string    `gorm:"column:nickname;type:varchar(50);NOT NULL"`                    // 昵称
	Account       string    `gorm:"column:account;type:varchar(100);NOT NULL"`                    // 账号
	Email         string    `gorm:"column:email;type:varchar(100)"`                               // 邮箱
	Password      string    `gorm:"column:password;type:varchar(100);NOT NULL"`                   // 密码
	UserType      uint      `gorm:"column:user_type;type:tinyint(3) unsigned;default:1;NOT NULL"` // 1-普通用户,2管理员,100超级管理员
	Status        uint      `gorm:"column:status;type:tinyint(3) unsigned;default:1;NOT NULL"`    // 1-可用,2-不可用,3-未激活
	Mobile        string    `gorm:"column:mobile;type:char(11)"`                                  // 手机号
	IconPath      string    `gorm:"column:icon_path;type:varchar(100)"`                           // 头像地址
	Bio           string    `gorm:"column:bio;type:varchar(200)"`                                 // 个人说明
	Token         string    `gorm:"column:token;type:varchar(100)"`                               // 登陆token
	TokenExpire   time.Time `gorm:"column:token_expire;type:datetime"`                            // token超时时间
	LastLoginIp   string    `gorm:"column:last_login_ip;type:varchar(100)"`                       // 最后登陆ip地址
	LastLoginTime time.Time `gorm:"column:last_login_time;type:datetime"`                         // 最后登陆时间
	DeletedAt     time.Time `gorm:"column:deleted_at;type:datetime(3)"`                           // 删除时间
	CreatedAt     time.Time `gorm:"column:created_at;type:datetime(3)"`                           // 创建时间
	UpdatedAt     time.Time `gorm:"column:updated_at;type:datetime(3)"`                           // 更新时间
}

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
