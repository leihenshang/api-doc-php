package doc

//CreateDocGroupRequest 创建文档分组
type CreateDocGroupRequest struct {
	Title string `json:"title" binding:"required,min=1,max=250"` // 标题
	PId   int    `json:"pId" binding:""`                         // 父级
	Icon  string `json:"icon" binding:""`                        // 图标
}

//UpdateDocGroupRequest 更新文档分组
type UpdateDocGroupRequest struct {
	Id    int    `json:"id" binding:"required"`
	Title string `json:"title" binding:"max=250"` // 标题
	PId   int    `json:"pId" binding:""`          // 父级
	Icon  string `json:"icon" binding:""`         // 图标
}
