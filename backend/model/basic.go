package model

import (
	"time"

	"gorm.io/gorm"
)

type BasicModel struct {
	ID         uint64         `json:"id"  gorm:"primaryKey"`
	UpdatedAt  *time.Time     `json:"createTime" column:update_time;`
	CreatedAt  *time.Time     `json:"updateTime" column:create_time;`
	DeleteTime gorm.DeletedAt `json:"deleteTime" gorm:"index"`
}
