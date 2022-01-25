package	model	
// CommonProperty [...]		
type	CommonProperty	struct {		
ID	int	`gorm:"primaryKey;column:id;type:int(11);not null" json:"-"`			
Key	string	`gorm:"column:key;type:varchar(100);not null" json:"key"`	// 标记名			
Group	string	`gorm:"column:group;type:varchar(100);not null;default:default" json:"group"`	// 分组			
Value	string	`gorm:"column:value;type:varchar(100);not null" json:"value"`	// 标记名			
Description	string	`gorm:"column:description;type:varchar(100)" json:"description"`	// 描述			
}		

// TableName get sql table name.获取数据库表名
func (m *CommonProperty) TableName() string {
	return "common_property"
}
	

// CommonPropertyColumns get sql column name.获取数据库列名
var CommonPropertyColumns = struct { 
	ID string
	Key string
	Group string
	Value string
	Description string    
	}{ 
		ID:"id",  
		Key:"key",  
		Group:"group",  
		Value:"value",  
		Description:"description",             
	}
	

