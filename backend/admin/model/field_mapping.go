package	model	
import (	
"time"	
)	
// FieldMapping 字段映射表		
type	FieldMapping	struct {		
ID	uint64	`gorm:"primaryKey;column:id;type:bigint(20) unsigned;not null" json:"-"`			
Field	string	`gorm:"column:field;type:varchar(100);not null" json:"field"`	// 字段			
Type	string	`gorm:"column:type;type:varchar(100);not null" json:"type"`	// 类型			
Description	string	`gorm:"column:description;type:varchar(100)" json:"description"`	// 描述			
ProjectID	uint64	`gorm:"column:project_id;type:bigint(20) unsigned;not null;default:0" json:"projectId"`	// 项目id			
CreateTime	time.Time	`gorm:"column:create_time;type:datetime;default:CURRENT_TIMESTAMP" json:"createTime"`			
DeleteTime	time.Time	`gorm:"column:delete_time;type:datetime" json:"deleteTime"`			
UpdateTime	time.Time	`gorm:"column:update_time;type:datetime;default:CURRENT_TIMESTAMP" json:"updateTime"`			
}		

// TableName get sql table name.获取数据库表名
func (m *FieldMapping) TableName() string {
	return "field_mapping"
}
	

// FieldMappingColumns get sql column name.获取数据库列名
var FieldMappingColumns = struct { 
	ID string
	Field string
	Type string
	Description string
	ProjectID string
	CreateTime string
	DeleteTime string
	UpdateTime string    
	}{ 
		ID:"id",  
		Field:"field",  
		Type:"type",  
		Description:"description",  
		ProjectID:"project_id",  
		CreateTime:"create_time",  
		DeleteTime:"delete_time",  
		UpdateTime:"update_time",             
	}
	

