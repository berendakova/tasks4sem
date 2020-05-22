<?php


namespace App\Controller;


class Test
{
    public function getPage(){
        $tmpl = new Tmpl();
        $tmpl->readerFile('tmpl.tmpl');
        $tmpl->set('{sometag}', 'Hello, World!'); //Заменяем тег на надпись
        $tmpl->loadnset('{moresometag}', 'sidebar.tpl'); //Подгружаем дочерний шаблон
//Все, теперь выводим шаблон:
        print $tmpl->get();
//или
        echo $tmpl->get();
    }
}