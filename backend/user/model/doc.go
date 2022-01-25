package model

type Doc struct {
	BasicModel
	UserId    int    `gorm:"column:user_id;type:int(11);default:0;NOT NULL" json:"user_id"`          // 用户id
	Title     string `gorm:"column:title;type:varchar(100);NOT NULL" json:"title"`                   // 标题
	Content   string `gorm:"column:content;type:text;NOT NULL" json:"content"`                       // 文档内容
	DocStatus int    `gorm:"column:doc_status;type:tinyint(4);default:0;NOT NULL" json:"doc_status"` // 1正常2审核中3禁用
	GroupId   int    `gorm:"column:group_id;type:int(11);default:0;NOT NULL" json:"group_id"`        // 分组id
	ViewCount int    `gorm:"column:view_count;type:int(11);default:0;NOT NULL" json:"view_count"`    // 查看次数
	LikeCount int    `gorm:"column:like_count;type:int(11);default:0;NOT NULL" json:"like_count"`    // 点赞次数
	IsTop     int    `gorm:"column:is_top;type:tinyint(4);default:0;NOT NULL" json:"is_top"`         // 是否置顶
	Priority  int    `gorm:"column:priority;type:int(255);default:0;NOT NULL" json:"priority"`       // 优先级
}

func (m *Doc) TableName() string {
	return "doc"
}
