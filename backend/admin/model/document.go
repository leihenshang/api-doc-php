package	model	
import (	
"time"	
)	
// Document [...]		
type	Document	struct {		
ID	uint64	`gorm:"primaryKey;column:id;type:bigint(20) unsigned;not null" json:"-"`	// id			
ProjectID	uint64	`gorm:"column:project_id;type:bigint(20) unsigned;not null;default:0" json:"projectId"`	// 项目id			
UserID	uint64	`gorm:"column:user_id;type:bigint(20) unsigned;not null;default:0" json:"userId"`	// 用户id			
Title	string	`gorm:"column:title;type:varchar(100);not null" json:"title"`	// 标题			
Content	string	`gorm:"column:content;type:text;not null" json:"content"`	// 内容			
Status	int8	`gorm:"column:status;type:tinyint(4);not null;default:0" json:"status"`	// 0正常1审核中2禁用			
GroupID	int	`gorm:"column:group_id;type:int(11);not null;default:0" json:"groupId"`	// 组id			
ViewCount	int	`gorm:"column:view_count;type:int(11);not null;default:0" json:"viewCount"`	// 查看数			
Priority	int	`gorm:"column:priority;type:int(11);not null;default:0" json:"priority"`	// 优先级			
LikeCount	int	`gorm:"column:like_count;type:int(11);not null;default:0" json:"likeCount"`	// 点赞数			
IsTop	uint8	`gorm:"column:is_top;type:tinyint(3) unsigned;not null;default:0" json:"isTop"`	// 是否置顶			
CreateTime	time.Time	`gorm:"column:create_time;type:datetime;default:CURRENT_TIMESTAMP" json:"createTime"`			
UpdateTime	time.Time	`gorm:"column:update_time;type:datetime;default:CURRENT_TIMESTAMP" json:"updateTime"`			
DeleteTime	time.Time	`gorm:"column:delete_time;type:datetime" json:"deleteTime"`			
}		

// TableName get sql table name.获取数据库表名
func (m *Document) TableName() string {
	return "document"
}
	

// DocumentColumns get sql column name.获取数据库列名
var DocumentColumns = struct { 
	ID string
	ProjectID string
	UserID string
	Title string
	Content string
	Status string
	GroupID string
	ViewCount string
	Priority string
	LikeCount string
	IsTop string
	CreateTime string
	UpdateTime string
	DeleteTime string    
	}{ 
		ID:"id",  
		ProjectID:"project_id",  
		UserID:"user_id",  
		Title:"title",  
		Content:"content",  
		Status:"status",  
		GroupID:"group_id",  
		ViewCount:"view_count",  
		Priority:"priority",  
		LikeCount:"like_count",  
		IsTop:"is_top",  
		CreateTime:"create_time",  
		UpdateTime:"update_time",  
		DeleteTime:"delete_time",             
	}
	

