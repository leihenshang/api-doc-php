package	model	
import (	
"time"	
)	
// Project 项目表		
type	Project	struct {		
ID	uint64	`gorm:"primaryKey;column:id;type:bigint(20) unsigned;not null" json:"-"`			
UserID	uint64	`gorm:"column:user_id;type:bigint(20) unsigned;not null;default:0" json:"userId"`	// 用户id			
Title	string	`gorm:"column:title;type:varchar(100);not null" json:"title"`	// 项目标题			
Version	string	`gorm:"column:version;type:varchar(100);not null;default:0" json:"version"`	// 版本			
Description	string	`gorm:"column:description;type:varchar(500)" json:"description"`	// 项目描述			
Type	string	`gorm:"column:type;type:varchar(100)" json:"type"`	// 类型			
CreateTime	time.Time	`gorm:"column:create_time;type:datetime;default:CURRENT_TIMESTAMP" json:"createTime"`	// 创建时间			
DeleteTime	time.Time	`gorm:"column:delete_time;type:datetime" json:"deleteTime"`			
UpdateTime	time.Time	`gorm:"column:update_time;type:datetime;default:CURRENT_TIMESTAMP" json:"updateTime"`			
}		

// TableName get sql table name.获取数据库表名
func (m *Project) TableName() string {
	return "project"
}
	

// ProjectColumns get sql column name.获取数据库列名
var ProjectColumns = struct { 
	ID string
	UserID string
	Title string
	Version string
	Description string
	Type string
	CreateTime string
	DeleteTime string
	UpdateTime string    
	}{ 
		ID:"id",  
		UserID:"user_id",  
		Title:"title",  
		Version:"version",  
		Description:"description",  
		Type:"type",  
		CreateTime:"create_time",  
		DeleteTime:"delete_time",  
		UpdateTime:"update_time",             
	}
	

