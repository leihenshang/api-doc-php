package model

// 分组表
type DocGroup struct {
	BasicModel
	Title    string `gorm:"column:title;type:varchar(100);NOT NULL" json:"title"`                // 组名
	Icon     string `gorm:"column:icon;type:varchar(100);NOT NULL" json:"icon"`                  // 图标
	PId      uint64 `gorm:"column:p_id;type:bigint(20) unsigned;default:0;NOT NULL" json:"p_id"` // 父级id
	Priority int    `gorm:"column:priority;type:int(11);default:0;NOT NULL" json:"priority"`     // 优先级
}

func (m *DocGroup) TableName() string {
	return "doc_group"
}
