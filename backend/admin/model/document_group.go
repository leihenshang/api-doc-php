package	model	
import (	
"time"	
)	
// DocumentGroup 文档组表		
type	DocumentGroup	struct {		
ID	uint64	`gorm:"primaryKey;column:id;type:bigint(20) unsigned;not null" json:"-"`			
PID	uint64	`gorm:"column:p_id;type:bigint(20) unsigned;not null;default:0" json:"pId"`	// 父级id			
ProjectID	uint64	`gorm:"column:project_id;type:bigint(20) unsigned;default:0" json:"projectId"`	// 项目id			
Title	string	`gorm:"column:title;type:varchar(100);not null" json:"title"`	// 组名			
Priority	int	`gorm:"column:priority;type:int(11);not null;default:0" json:"priority"`	// 优先级			
CreateTime	time.Time	`gorm:"column:create_time;type:datetime;default:CURRENT_TIMESTAMP" json:"createTime"`			
DeleteTime	time.Time	`gorm:"column:delete_time;type:datetime" json:"deleteTime"`			
UpdateTime	time.Time	`gorm:"column:update_time;type:datetime;default:CURRENT_TIMESTAMP" json:"updateTime"`			
}		

// TableName get sql table name.获取数据库表名
func (m *DocumentGroup) TableName() string {
	return "document_group"
}
	

// DocumentGroupColumns get sql column name.获取数据库列名
var DocumentGroupColumns = struct { 
	ID string
	PID string
	ProjectID string
	Title string
	Priority string
	CreateTime string
	DeleteTime string
	UpdateTime string    
	}{ 
		ID:"id",  
		PID:"p_id",  
		ProjectID:"project_id",  
		Title:"title",  
		Priority:"priority",  
		CreateTime:"create_time",  
		DeleteTime:"delete_time",  
		UpdateTime:"update_time",             
	}
	

