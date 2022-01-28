package model

// 分组表
type DocGroup struct {
	BasicModel
	UserId   uint64 `gorm:"column:user_id;default:0;NOT NULL"`  // 用户Id
	Title    string `gorm:"column:title;NOT NULL"`              // 组名
	Icon     string `gorm:"column:icon;NOT NULL"`               // 图标
	PId      uint64 `gorm:"column:p_id;default:0;NOT NULL"`     // 父级id
	Priority int    `gorm:"column:priority;default:0;NOT NULL"` // 优先级
}

func (m *DocGroup) TableName() string {
	return "doc_group"
}
