; 回复
id bigint(20) auto primary comment="回复ID"
aritcle  bigint(20) key comment="回复的文章"
comment  int(11) key comment="回复的评论"
author   bigint(20) key comment="回复的人"
text     varchar(500)  comment="回复内容"
time     int(11)    comment="回复的时间"
ip       varchar(20) comment="回复IP"
state    tinyint(1)  key comment="状态"