package	model	
import (	
"time"	
)	
// UserProjectRelation 团队项目表		
type	UserProjectRelation	struct {		
ID	int	`gorm:"primaryKey;column:id;type:int(11);not null" json:"-"`			
UserID	int	`gorm:"column:user_id;type:int(11);not null;default:0" json:"userId"`			
ProjectID	int	`gorm:"column:project_id;type:int(11);not null;default:0" json:"projectId"`			
IsLeader	int8	`gorm:"column:is_leader;type:tinyint(4);not null;default:0" json:"isLeader"`			
DeleteTime	time.Time	`gorm:"column:delete_time;type:datetime" json:"deleteTime"`			
CreateTime	time.Time	`gorm:"column:create_time;type:datetime;default:CURRENT_TIMESTAMP" json:"createTime"`			
Permission	int8	`gorm:"column:permission;type:tinyint(4);not null;default:6" json:"permission"`	// 4读2写			
UpdateTime	time.Time	`gorm:"column:update_time;type:datetime;default:CURRENT_TIMESTAMP" json:"updateTime"`			
}		

// TableName get sql table name.获取数据库表名
func (m *UserProjectRelation) TableName() string {
	return "user_project_relation"
}
	

// UserProjectRelationColumns get sql column name.获取数据库列名
var UserProjectRelationColumns = struct { 
	ID string
	UserID string
	ProjectID string
	IsLeader string
	DeleteTime string
	CreateTime string
	Permission string
	UpdateTime string    
	}{ 
		ID:"id",  
		UserID:"user_id",  
		ProjectID:"project_id",  
		IsLeader:"is_leader",  
		DeleteTime:"delete_time",  
		CreateTime:"create_time",  
		Permission:"permission",  
		UpdateTime:"update_time",             
	}
	

