<?php /// 访问规则
 Page::visitController((new Page_Controller(function ($id, $name) {
     echo 'OK ==> ', $id, $name;
 }))-> url('/{id}/{name}')->with('id', 'int')->with('name', 'string'));
    
 Page::visit('/getUser/{id}', function ($id=0) {
     var_dump(Page::url('main', ['id'=>5, 'name'=>'urlpage']));
     return (new Qurey('SELECT * FROM `#{users}` WHERE `uid`=:uid LIMIT 1;', ['uid'=>$id]))->fetch();
 })
    ->with('id', 'int')
    ->json();

Page::default(function ($path) {
      $extension=pathinfo($path, PATHINFO_EXTENSION);
      // Resource
      if (array_key_exists($extension, mime()) && Storage::exist($path=View::tplRoot().'/'.$path)) {
          Page::controller()->type($extension)->raw();
          echo Storage::get($path);
      } else {
          View::set('title', '页面找不到了哦！');
          View::set('url', $path);
      }
  })->use(404);
Page::auto('/admin', ['/admin']);