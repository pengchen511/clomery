<?php
class Main
{
    function main()
    {
        View::set('title','管理页面 - 三人行，必有我师焉。');
     // 测试SQL
       $data=(new Query('SELECT * FROM `#{users}` LIMIT 3;'))->fetchAll();
       $head_index=[
           [
               'text'=>'计科Online',
               'url'=>Page::url('main_page'),
           ],
           [
               'text'=>'文章',
               'url'=>'/article/',
           ],
           [
               'text'=>'问答',
           ],
           [
               'text'=>'资源',
           ],
           [
               'title'=>'OJ测试',
               'text'=>'测试',
           ]
       ];
       View::set('head_index',$head_index);

    }
    function article(int $id)
    {
       //  var_dump($id);
        View::set('title','文章阅读 '.$id.' - 三人行，必有我师焉。');
    }
}