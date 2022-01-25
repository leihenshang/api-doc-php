package	model	
import (	
"time"	
)	
// ProjectOperationLog 操作日志		
type	ProjectOperationLog	struct {		
ID	int	`gorm:"primaryKey;column:id;type:int(11);not null" json:"-"`			
ProjectID	uint64	`gorm:"column:project_id;type:bigint(20) unsigned;not null" json:"projectId"`	// 项目id			
UserID	uint64	`gorm:"column:user_id;type:bigint(20) unsigned;not null;default:0" json:"userId"`	// 操作用户			
Action	string	`gorm:"column:action;type:varchar(100);not null" json:"action"`	// 动作			
Description	string	`gorm:"column:description;type:varchar(500)" json:"description"`	// 操作内容			
ObjectID	int	`gorm:"column:object_id;type:int(11);not null;default:0" json:"objectId"`	// 项目id			
ObjectType	int8	`gorm:"column:object_type;type:tinyint(4);not null;default:0" json:"objectType"`	// 1项目2分组3api4用户5文档			
CreateTime	time.Time	`gorm:"column:create_time;type:datetime;default:CURRENT_TIMESTAMP" json:"createTime"`			
DeleteTime	time.Time	`gorm:"column:delete_time;type:datetime" json:"deleteTime"`			
UpdateTime	time.Time	`gorm:"column:update_time;type:datetime;default:CURRENT_TIMESTAMP" json:"updateTime"`			
}		

// TableName get sql table name.获取数据库表名
func (m *ProjectOperationLog) TableName() string {
	return "project_operation_log"
}
	

// ProjectOperationLogColumns get sql column name.获取数据库列名
var ProjectOperationLogColumns = struct { 
	ID string
	ProjectID string
	UserID string
	Action string
	Description string
	ObjectID string
	ObjectType string
	CreateTime string
	DeleteTime string
	UpdateTime string    
	}{ 
		ID:"id",  
		ProjectID:"project_id",  
		UserID:"user_id",  
		Action:"action",  
		Description:"description",  
		ObjectID:"object_id",  
		ObjectType:"object_type",  
		CreateTime:"create_time",  
		DeleteTime:"delete_time",  
		UpdateTime:"update_time",             
	}
	

