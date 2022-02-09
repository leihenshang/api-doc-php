package model

import (
	"time"
)

// API api表
type API struct {
	ID                      uint64    `gorm:"primaryKey;column:id;type:bigint(20) unsigned;not null" json:"-"`
	GroupID                 uint64    `gorm:"column:group_id;type:bigint(20) unsigned;not null;default:0" json:"groupId"`       // 组id
	ProjectID               uint64    `gorm:"column:project_id;type:bigint(20) unsigned;not null;default:0" json:"projectId"`   // 项目id
	Description             string    `gorm:"column:description;type:varchar(500)" json:"description"`                          // 备注
	GroupIDSecond           int       `gorm:"column:group_id_second;type:int(11);not null;default:0" json:"groupIdSecond"`      // 二级分组
	ProtocolType            string    `gorm:"column:protocol_type;type:varchar(100);not null;default:HTTP" json:"protocolType"` // 协议
	HTTPMethod              string    `gorm:"column:http_method;type:varchar(100)" json:"httpMethod"`                           // Http请求类型
	RoutePath               string    `gorm:"column:route_path;type:varchar(500)" json:"routePath"`                             // 路径
	APIName                 string    `gorm:"column:api_name;type:varchar(200)" json:"apiName"`                                 // 名称
	ObjectName              string    `gorm:"column:object_name;type:varchar(100)" json:"objectName"`                           // 对象名
	FunctionName            string    `gorm:"column:function_name;type:varchar(100)" json:"functionName"`                       // 方法名
	DevelopLanguage         string    `gorm:"column:develop_language;type:varchar(100)" json:"developLanguage"`                 // 开发语言
	HTTPRequestHeader       string    `gorm:"column:http_request_header;type:text" json:"httpRequestHeader"`                    // http头
	HTTPRequestQuery        string    `gorm:"column:http_request_query;type:text" json:"httpRequestQuery"`
	HTTPRequestBodyType     string    `gorm:"column:http_request_body_type;type:varchar(100);not null;default:form" json:"httpRequestBodyType"` // 1form2json3raw
	HTTPRequestBody         string    `gorm:"column:http_request_body;type:text" json:"httpRequestBody"`                                        // http请求参数
	HTTPReturnSampleSuccess string    `gorm:"column:http_return_sample_success;type:text" json:"httpReturnSampleSuccess"`                       // http响应数据样例
	HTTPReturnSampleError   string    `gorm:"column:http_return_sample_error;type:text" json:"httpReturnSampleError"`                           // http响应数据样例
	HTTPReturnType          uint8     `gorm:"column:http_return_type;type:tinyint(3) unsigned;not null;default:0" json:"httpReturnType"`        // 0,1-json,2-raw
	HTTPReturnData          string    `gorm:"column:http_return_data;type:longtext" json:"httpReturnData"`                                      // http请求响应
	CreateTime              time.Time `gorm:"column:create_time;type:datetime;default:CURRENT_TIMESTAMP" json:"createTime"`
	UpdateTime              time.Time `gorm:"column:update_time;type:datetime;default:CURRENT_TIMESTAMP" json:"updateTime"`
	DeleteTime              time.Time `gorm:"column:delete_time;type:datetime" json:"deleteTime"`
}

// TableName get sql table name.获取数据库表名
func (m *API) TableName() string {
	return "api"
}

// APIColumns get sql column name.获取数据库列名
var APIColumns = struct {
	ID                      string
	GroupID                 string
	ProjectID               string
	Description             string
	GroupIDSecond           string
	ProtocolType            string
	HTTPMethod              string
	RoutePath               string
	APIName                 string
	ObjectName              string
	FunctionName            string
	DevelopLanguage         string
	HTTPRequestHeader       string
	HTTPRequestQuery        string
	HTTPRequestBodyType     string
	HTTPRequestBody         string
	HTTPReturnSampleSuccess string
	HTTPReturnSampleError   string
	HTTPReturnType          string
	HTTPReturnData          string
	CreateTime              string
	UpdateTime              string
	DeleteTime              string
}{
	ID:                      "id",
	GroupID:                 "group_id",
	ProjectID:               "project_id",
	Description:             "description",
	GroupIDSecond:           "group_id_second",
	ProtocolType:            "protocol_type",
	HTTPMethod:              "http_method",
	RoutePath:               "route_path",
	APIName:                 "api_name",
	ObjectName:              "object_name",
	FunctionName:            "function_name",
	DevelopLanguage:         "develop_language",
	HTTPRequestHeader:       "http_request_header",
	HTTPRequestQuery:        "http_request_query",
	HTTPRequestBodyType:     "http_request_body_type",
	HTTPRequestBody:         "http_request_body",
	HTTPReturnSampleSuccess: "http_return_sample_success",
	HTTPReturnSampleError:   "http_return_sample_error",
	HTTPReturnType:          "http_return_type",
	HTTPReturnData:          "http_return_data",
	CreateTime:              "create_time",
	UpdateTime:              "update_time",
	DeleteTime:              "delete_time",
}
