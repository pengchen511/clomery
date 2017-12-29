<?php
namespace cn\atd3\article\dao;

use suda\archive\Table;
use suda\tool\Pinyin;
use suda\core\Request;
use suda\core\Query;
use cn\atd3\upload\{File,UploadProxy};


class AttachmentTable extends Table
{
    const STATUS_DELETE=0;     // 删除
    const STATUS_DRAFT=1;      // 草稿
    const STATUS_PUBLISH=2;    // 发布

    const TYPE_ATTACHMEMT=0;
    const TYPE_RESOURCE=1;

    public function __construct()
    {
        parent::__construct('article_attachment');
    }

    public function onBuildCreator($table)
    {
        return $table->fields(
            $table->field('id', 'bigint', 20)->primary()->unsigned()->auto(),
            $table->field('aid', 'bigint', 20)->unsigned()->key()->comment("文章ID"),
            $table->field('fid', 'bigint', 20)->unsigned()->key()->comment("文件ID"),
            $table->field('type', 'tinyint', 1)->key()->comment("附件或者资源"),
            $table->field('time', 'int', 11)->key()->comment("时间"),
            $table->field('ip', 'varchar', 32)->comment("IP"),
            $table->field('status', 'tinyint', 1)->key()->comment("状态")
        );
    }

    public function addArticleResource(File $file,int $article) {
        $file=proxy('upload')->save($file,'article_resource_'.$article,UploadProxy::STATE_PUBLISH,UploadProxy::FILE_PUBLIC);
        $this->insert(['aid'=>$article,'fid'=>$file->getId(),'time'=>time(),'ip'=>request()->ip()]);
        return $file->getUrl();
    }

    // public function getAttachmentById(int $article) {
    //     $this->listWhere(['fid','time'])
    // }
}