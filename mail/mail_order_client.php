<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <title>HTML Template</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <!-- <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600" rel="stylesheet" /> -->
   <style>
      body {
         width: 100% !important;
         -webkit-text-size-adjust: 100%;
         -ms-text-size-adjust: 100%;
         margin: 0;
         padding: 0;
         line-height: 100%;
         /* font: 17px/24px Roboto,Arial,sans-serif !important; */
         font: Roboto, Arial, sans-serif !important;
      }

      /* [style*="Raleway"] {
         font-family: 'Raleway', arial, sans-serif !important;
      } */

      img {
         outline: none;
         text-decoration: none;
         border: none;
         -ms-interpolation-mode: bicubic;
         max-width: 100% !important;
         margin: 0;
         padding: 0;
         display: block;
      }

      table td {
         border-collapse: collapse;
      }

      table {
         border-collapse: collapse;
         mso-table-lspace: 0pt;
         mso-table-rspace: 0pt;
      }

      .table-order {
         border-radius: 10px;
         border-top: 1px solid #9aff5a;
         border-right: 1px solid #9aff5a;
         border-left: 1px solid #9aff5a;
         display: block;
         padding: 0 10px;
         border-spacing: 7px 11px;
      }

      .table-order td {
         padding: 10px 0;
      }

      .table-order tr {
         border-bottom: 1px solid #9aff5a;
      }



      .mail-title {
         font: 17px/24px Roboto, Arial, sans-serif;
         color: #222;
      }

      .mail-text {
         font: 15px/20px Roboto, Arial, sans-serif;
         color: #222;
      }
   </style>

</head>

<body>

</body>
<table cellpadding="0" cellspacing="0" width="98%">
   <tr>
      <td>
         <table class="main table-850" cellpadding="0" cellspacing="0" width="800" align="center">
            <tr>
               <!-- лого -->
               <td bgcolor="#ffffff">
                  <table class="table-600" cellpadding="0" cellspacing="0" width="600" align="center">
                     <tr>
                        <td align="center" class="mail-logo">
                           <a href="<?= PATH ?>" class="header__logo">
                              <img src="<?= PATH ?>views/img/logo.png" alt="Аптека Неболейка" height="50">
                           </a>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr><!-- /лого -->
            <tr>
               <!-- отступ -->
               <td height="50" width="850" bgcolor="#ffffff"></td>
            </tr><!-- /отступ -->
            <tr>
               <td bgcolor="#ffffff">
                  <table class="table-600 mail-title" cellpadding="0" cellspacing="0" width="600" align="center">
                     <tr>
                        <td>
                           Здравствуйте, <b><?= $_SESSION['order']['name'] ?></b>!<br />
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>

            <?php if (empty($_SESSION['order']['addres'])) : ?>
               <tr>
                  <td bgcolor="#ffffff">
                     <table class="table-600 mail-title" cellpadding="0" cellspacing="0" width="600" align="center">
                        <tr>
                           <td>
                              Ваш заказ уже ждет Вас в аптеке по адресу: <b>пр.Просвещения, д.20/25</b><br />
                           </td>
                        </tr>
                     </table>
                  </td>
               </tr>
            <?php else : ?>
               <tr>
                  <td bgcolor="#ffffff">
                     <table class="table-600 mail-title" cellpadding="0" cellspacing="0" width="600" align="center">
                        <tr>
                           <td>
                              Адрес доставки: <b><?= $_SESSION['order']['addres'] ?></b><br />
                           </td>
                        </tr>
                     </table>
                  </td>
               </tr>
            <?php endif; ?>

            <tr>
               <td>
                  <table class="table-600 mail-title" cellpadding="0" cellspacing="0" width="600" align="center">
                     <tr>
                        <td>
                           Номер заказа: <b>№<?= $order_id ?></b><br />
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr>
               <td>
                  <table class="table-600 mail-title" cellpadding="0" cellspacing="0" width="600" align="center">
                     <tr>
                        <td>
                           Телефон: <?= $_SESSION['order']['phone'] ?><br />
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>

            <?php if (!empty($_SESSION['order']['prim'])) : ?>
               <tr>
                  <td>
                     <table class="table-600 mail-title" cellpadding="0" cellspacing="0" width="600" align="center">
                        <tr>
                           <td>
                              Примечание: <?= $_SESSION['order']['prim'] ?><br />
                           </td>
                        </tr>
                     </table>
                  </td>
               </tr>
            <?php endif; ?>
            <tr>
               <td bgcolor="#ffffff">
                  <table class="table-600 mail-title" cellpadding="0" cellspacing="0" width="600" align="center">
                     <tr>
                        <td>
                           <br /><u>Состав заказа:</u><br /><br />
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr>
               <td bgcolor="#ffffff">
                  <table class="table-600 table-order mail-text" cellpadding="0" cellspacing="0" width="550" align="center" bgcolor="#ffffff">
                     <?php foreach ($_SESSION['cart'] as $goods_id => $value) : ?>
                        <tr>
                           <td align="left" class="mail-tovname" width="300">
                              <?= $value['tovName'] ?>
                           </td>
                           <td align="center" class="" width="150">
                              <?= $value['pricerozn'] ?> руб. х <?= $value['qty'] ?> шт.
                           </td>
                           <td align="center" class="" width="100">
                              <b><?= $value['pricerozn'] * $value['qty'] ?> руб.</b>
                           </td>
                        </tr>
                     <?php endforeach; ?>
                  </table>
               </td>
            </tr>

            <tr>
               <!-- отступ -->
               <td height="10" width="850" bgcolor="#ffffff"></td>
            </tr><!-- /отступ -->



            <tr>
               <td bgcolor="#ffffff">
                  <table class="table-600" cellpadding="0" cellspacing="0" width="550" align="center">
                     <tr>
                        <td align="right" class="mail-title" width="450" align="center">
                           Общая стоимость заказа:
                        </td>
                        <td align="center" class="mail-title" width="100">
                           <b><?= $_SESSION['total_sum'] ?> руб.</b>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr>
               <!-- отступ -->
               <td height="40" width="850" bgcolor="#ffffff"></td>
            </tr><!-- /отступ -->
            <tr>
               <td bgcolor="#ffffff">
                  <table class="table-600 mail-text" cellpadding="0" cellspacing="0" width="600" align="center">
                     <tr>
                        <td>
                           <i>Данное письмо отправлено автоматически и не требует ответа. В случае изменения или отмены заказа, а также по другим вопросам, свяжитесь с нами по e-mail: <a href="mailto:aneboleyka@mail.ru">aneboleyka@mail.ru</a> или телефону <a href="tel:+78122421872">+7 (812) 242-18-72</a></i>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <i>Не является публичной офертой</i>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr>
               <!-- отступ -->
               <td height="20" width="850" bgcolor="#ffffff"></td>
            </tr><!-- /отступ -->
         </table>
      </td>
   </tr>

</table>
</body>

</html>