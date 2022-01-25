package model

import (
	"time"
)

// VerifyCode [...]
type VerifyCode struct {
	ID         uint64    `gorm:"primaryKey;column:id;type:bigint(20) unsigned;not null" json:"-"`
	UserID     uint64    `gorm:"column:user_id;type:bigint(20) unsigned;not null;default:0" json:"userId"` // 用户id
	Content    string    `gorm:"column:content;type:varchar(500)" json:"content"`                          // 内容
	Title      string    `gorm:"column:title;type:varchar(100)" json:"title"`                              // 标题
	ExpireTime time.Time `gorm:"column:expire_time;type:datetime;not null" json:"expireTime"`              // 过期时间
	UsedTime   time.Time `gorm:"column:used_time;type:datetime" json:"usedTime"`                           // 使用时间
	IsUsed     int8      `gorm:"column:is_used;type:tinyint(4);not null;default:0" json:"isUsed"`          // 0正常1已使用
	Code       string    `gorm:"column:code;type:varchar(100)" json:"code"`                                // 验证码
	CreateTime time.Time `gorm:"column:create_time;type:datetime;default:CURRENT_TIMESTAMP" json:"createTime"`
	UpdateTime time.Time `gorm:"column:update_time;type:datetime;default:CURRENT_TIMESTAMP" json:"updateTime"`
	DeleteTime time.Time `gorm:"column:delete_time;type:datetime" json:"deleteTime"`
}

// TableName get sql table name.获取数据库表名
func (m *VerifyCode) TableName() string {
	return "verify_code"
}

// VerifyCodeColumns get sql column name.获取数据库列名
var VerifyCodeColumns = struct {
	ID         string
	UserID     string
	Content    string
	Title      string
	ExpireTime string
	UsedTime   string
	IsUsed     string
	Code       string
	CreateTime string
	UpdateTime string
	DeleteTime string
}{
	ID:         "id",
	UserID:     "user_id",
	Content:    "content",
	Title:      "title",
	ExpireTime: "expire_time",
	UsedTime:   "used_time",
	IsUsed:     "is_used",
	Code:       "code",
	CreateTime: "create_time",
	UpdateTime: "update_time",
	DeleteTime: "delete_time",
}
