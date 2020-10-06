<?php
defined("CATALOG") or die("Access denied");



/**
 *Добавление заказа
 */
function add_order(){
    // получаем общие данные для всех (авторизованные и не очень)
    $dostavka_id = (int)$_POST['dostavka'];
    if(!$dostavka_id) $dostavka_id = 1;
    $prim = clear($_POST['prim']);
    if($_SESSION['auth']['user']) $customer_id = $_SESSION['auth']['customer_id'];

    if(!$_SESSION['auth']['user']){
        $error = ''; // флаг проверки пустых полей

        $name = clear($_POST['name']);

        $email = clear($_POST['email']);
        $phone = clear($_POST['phone']);
        $address = clear($_POST['address']);

        if(empty($error)){
            // добавляем гостя в заказчики (но без данных авторизации)
            $customer_id = add_customer($name, $email, $phone, $address);
            if(!$customer_id) return false; // прекращаем выполнение в случае возникновения ошибки добавления гостя-заказчика
        }else{
            // если не заполнены обязательные поля
            $_SESSION['order']['res'] = "<div class='error'>Не заполнены обязательные поля: <ul> $error </ul></div>";
            $_SESSION['order']['name'] = $name;
            $_SESSION['order']['email'] = $email;
            $_SESSION['order']['phone'] = $phone;
            $_SESSION['order']['addres'] = $address;
            $_SESSION['order']['prim'] = $prim;
            return false;
        }
    }

    $_SESSION['order']['name'] = $name;
    $_SESSION['order']['email'] = $email;
    $_SESSION['order']['phone'] = $phone;
    $_SESSION['order']['addres'] = $address;
    $_SESSION['order']['prim'] = $prim;
    save_order($customer_id, $dostavka_id, $prim);
}

/**
 *Добавление заказчика-гостя
 */
function add_customer($name, $email, $phone, $address){
    $query = "INSERT INTO customers (name, email, phone, address)
                VALUES ('$name', '$email', '$phone', '$address')";
    $res = mysqli_query($GLOBALS['connection'], $query);
    if(mysqli_affected_rows($GLOBALS['connection']) > 0){
        // если гость добавлен в заказчики - получаем его ID
        return mysqli_insert_id($GLOBALS['connection']);
    }else{
        // если произошла ошибка при добавлении
        $_SESSION['order']['res'] = "<div class='error'>Произошла ошибка при регистрации заказа</div>";
        $_SESSION['order']['name'] = $name;
        $_SESSION['order']['email'] = $email;
        $_SESSION['order']['phone'] = $phone;
        $_SESSION['order']['addres'] = $address;
        $_SESSION['order']['prim'] = $address;
        return false;
    }
}


/**
 *Сохранение заказа
 */
function save_order($customer_id, $dostavka_id, $prim){
    $query = "INSERT INTO orders (`customer_id`, `date`, `dostavka_id`, `prim`)
                VALUES ($customer_id, NOW(), $dostavka_id, '$prim')";
    mysqli_query($GLOBALS['connection'], $query) or die(mysqli_error($GLOBALS['connection']));
    if(mysqli_affected_rows($GLOBALS['connection']) == -1){
        // если не получилось сохранить заказ - удаляем заказчика
        mysqli_query($GLOBALS['connection'], "DELETE FROM customers
                        WHERE customer_id = $customer_id AND login = ''");
        return false;
    }
    $order_id = mysqli_insert_id($GLOBALS['connection']); // ID сохраненного заказа

    $val = '';
    foreach($_SESSION['cart'] as $goods_id => $value){
        $val .= "($order_id, {$value['regid']}, {$value['qty']}),";
    }
    $val = substr($val, 0, -1); // удаляем последнюю запятую

    $query = "INSERT INTO zakaz_tovar (orders_id, goods_id, quantity)
                VALUES $val";
    mysqli_query($GLOBALS['connection'], $query) or die(mysqli_error($GLOBALS['connection']));
    if(mysqli_affected_rows($GLOBALS['connection']) == -1){
        // если не выгрузился заказа - удаляем заказчика (customers) и заказ (orders)
        mysqli_query($GLOBALS['connection'], "DELETE FROM orders WHERE order_id = $order_id");
        mysqli_query($GLOBALS['connection'], "DELETE FROM customers
                        WHERE customer_id = $customer_id AND login = ''");
        return false;
    }


    if ($_SESSION['auth']['email']) $email = $_SESSION['auth']['email'];//авторизован
    else $email = $_SESSION['order']['email']; //не авторизован
    
    //отправка писем
    mail_order($order_id, $email);
    
    // если заказ выгрузился
    unset($_SESSION['cart']);
    unset($_SESSION['total_sum']);
    unset($_SESSION['total_quantity']);
    $_SESSION['order']['res'] = "<div class='order-success'>Ваш <span>заказ №{$order_id}</span> принят!<br> Данные о заказе отправлены на e-mail, указанный при оформлении.<br>Спасибо за Ваш заказ.</div>";
    return true;
}


/**
 * Отправка писем о заказе
 * @param $order_id
 * @param $email
 */
function mail_order($order_id, $email){
    //mail(to, subject, body, header);//куда, тема, тело, определить кодировку
    // тема письма
    $subject = "Новый заказ №{$order_id}";
    // заголовки
    $headers = "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "From: Аптека Неболейка <" . ADMIN_EMAIL . ">\r\n";

    ob_start(); // включаем буферизацию
    require 'mail/mail_order_client_inline.php'; // подключаем шаблон письма
    $mail_body = ob_get_clean(); // выгружаем письмо из буфера   
    if (!empty($email)) {
        mail($email, $subject, $mail_body, $headers);
    }
    mail('iva2742@mail.ru', $subject, $mail_body, $headers);

    ob_start(); // включаем буферизацию
    require 'mail/mail_order_admin_inline.php'; // подключаем шаблон письма
    $mail_body = ob_get_clean(); // выгружаем письмо из буфера
    mail('aneboleyka@mail.ru', $subject, $mail_body, $headers);//возможно стоит указать настоящий email админа жестко
}