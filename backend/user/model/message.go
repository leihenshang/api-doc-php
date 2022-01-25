package	model	
import (	
"time"	
)	
// Message [...]		
type	Message	struct {		
ID	uint64	`gorm:"primaryKey;column:id;type:bigint(20) unsigned;not null" json:"-"`			
Title	string	`gorm:"column:title;type:varchar(100);not null" json:"title"`	// 标题			
Content	string	`gorm:"column:content;type:varchar(500)" json:"content"`	// 内容			
Type	uint8	`gorm:"column:type;type:tinyint(3) unsigned;not null;default:0" json:"type"`	// 0默认1系统消息			
UserID	uint64	`gorm:"column:user_id;type:bigint(20) unsigned;not null" json:"userId"`	// 接收者			
Read	int8	`gorm:"column:read;type:tinyint(4);not null;default:0" json:"read"`	// 0未读1已读			
CreateTime	time.Time	`gorm:"column:create_time;type:datetime;default:CURRENT_TIMESTAMP" json:"createTime"`			
DeleteTime	time.Time	`gorm:"column:delete_time;type:datetime" json:"deleteTime"`			
UpdateTime	time.Time	`gorm:"column:update_time;type:datetime;default:CURRENT_TIMESTAMP" json:"updateTime"`			
}		

// TableName get sql table name.获取数据库表名
func (m *Message) TableName() string {
	return "message"
}
	

// MessageColumns get sql column name.获取数据库列名
var MessageColumns = struct { 
	ID string
	Title string
	Content string
	Type string
	UserID string
	Read string
	CreateTime string
	DeleteTime string
	UpdateTime string    
	}{ 
		ID:"id",  
		Title:"title",  
		Content:"content",  
		Type:"type",  
		UserID:"user_id",  
		Read:"read",  
		CreateTime:"create_time",  
		DeleteTime:"delete_time",  
		UpdateTime:"update_time",             
	}
	

