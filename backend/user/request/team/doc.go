package team

//CreateTeamRequest 创建文档
type CreateTeamRequest struct {
	Title   string `json:"title" binding:"required,min=1,max=250"`    // 标题
	Content string `json:"content" binding:"required,min=1,max=2500"` // 文档内容
	GroupId int    `json:"groupId" binding:""`                        // 分组id
	IsTop   int    `json:"isTop" binding:""`                          // 是否置顶
}

//UpdateTeamRequest 更新文档
type UpdateTeamRequest struct {
	Id      int    `json:"id" binding:"required"`
	Title   string `json:"title" binding:"max=250"`    // 标题
	Content string `json:"content" binding:"max=2500"` // 文档内容
	GroupId int    `json:"groupId" binding:""`         // 分组id
	IsTop   int    `json:"isTop" binding:""`           // 是否置顶
}
