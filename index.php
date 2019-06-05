<?php
$list = new Passwordlist(5);
$db = new  Db('','','','');
//выбираем из базы данных, все сохраненные пароли, для конкретного пользователя
$passwordsList = $db->getPasswordsList(1);

//есть ли совпадения с текущим отправленным паролем
if($passwordsList && array_search(md5($_POST['password']),$passwordsList) !== FALSE) {
    echo 'This password cannot be used.';
}
else {// формируем очередь из выбранных элементов, добавляем в нее новый пароль и сохраняем изменения в базу данных
    $pwd = md5($_POST['password']);
    if($passwordsList) {
        foreach($passwordsList as $item) {
            $list->enqueue($item);
        }
    }
    $list->enqueue($pwd);


    if($db->changePassword($_POST,1)) {
        $db->saveList($list->toArray(),1);
        header("Location:index.php");
        exit();
    }
}