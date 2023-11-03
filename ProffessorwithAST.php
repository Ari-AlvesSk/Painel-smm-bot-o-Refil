<?php

$first_route = explode('?', $_SERVER['REQUEST_URI']);
$gets = explode('&', $first_route[1]);
foreach ($gets as $get)
{
    $get = explode('=', $get);
    $_GET[$get[0]] = $get[1];
}
$routes = array_filter(explode('/', $first_route[0]));

foreach ($routes as $index => $value):
    $route[$index - 1] = $value;
endforeach;

if ($settings['site_maintenance'] == 2 && $settings["cache"] == 2 && (route(0) == 'faq' || route(0) == 'terms' || route(0) == 'services' || route(0) == 'blog'))
{

    if ($_SESSION['neira_userlogin'] == true)
    {
        $dosya_isim = 'signed-' . md5($_SERVER['REQUEST_URI'] . $_SERVER['REMOTE_ADDR']);
    }
    else
    {
        $dosya_isim = 'guest-' . md5($_SERVER['REQUEST_URI'] . $_SERVER['REMOTE_ADDR']);

    }
    $dosya_yolu = 'cache/' . $dosya_isim . '.gly';
    $cache_suresi = $settings["cache_time"] * 60 * 60;

    if (file_exists($dosya_yolu))
    {
        if (time() - $cache_suresi < filemtime($dosya_yolu))
        {
            die(require_once ($dosya_yolu));
        }
        else
        {
            unlink($dosya_yolu);
        }
    }
    ob_start();
}

if ($settings["site_currency"] == "BRL")
{
    $currency = "R$";
}

if ($_GET['lang'] && $user['auth'] != 1):
    if (countRow(['table' => 'languages', 'where' => ['language_type' => 2, 'language_code' => $_GET['lang']]])):
        unset($_SESSION['lang']);
        $_SESSION['lang'] = $_GET['lang'];
        include 'system/language/' . $_GET['lang'] . '.php';
    else:
        $_SESSION['lang'] = $_GET['lang'];
        include 'system/language/' . $_GET['lang'] . '.php';
    endif;
    $selectedLang = $_SESSION['lang'];
    header('Location:' . site_url());
else:
    if ($_SESSION['lang'] && $user['auth'] != 1):
        $language = $_SESSION['lang'];
    elseif ($user['auth'] != 1):
        $language = $conn->prepare('SELECT * FROM languages WHERE default_language=:default ');
        $language->execute(array(
            'default' => 1
        ));
        $language = $language->fetch(PDO::FETCH_ASSOC);
        $language = $language['language_code'];
    else:
        if (getRow(['table' => 'languages', 'where' => ['language_code' => $user['lang']]])):
            $language = $user['lang'];
        else:
            $language = $conn->prepare('SELECT * FROM languages WHERE default_language=:default ');
            $language->execute(array(
                'default' => 1
            ));
            $language = $language->fetch(PDO::FETCH_ASSOC);
            $language = $language['language_code'];
        endif;
    endif;
    include 'language/' . $language . '.php';
    $selectedLang = $language;
endif;

if (!isset($route[0]) && $_SESSION['neira_userlogin'] == true)
{
    $route[0] = 'neworder';
    $routeType = 0;
}
elseif (!isset($route[0]) && $_SESSION['neira_userlogin'] == false)
{
    $route[0] = 'auth';
    $routeType = 1;
}
elseif ($route[0] == 'auth' && $_SESSION['neira_userlogin'] == false)
{
    $routeType = 1;
}
else
{
    $routeType = 0;
}

if (route(0) == 'select-theme')
{

    if (!countRow(['table' => 'themes', 'where' => ['theme_dirname' => route(1) ]])):
        header("Location:" . site_url());
        exit();
    endif;

    $_SESSION['theme'] = route(1);

    header('Location:' . site_url());

}

if (route(0) == 'ref')
{
    $ref = route(1);
    if ($ref)
    {

        $refcontrol = $conn->prepare('SELECT * FROM clients WHERE referral_code=:code');
        $refcontrol->execute(array(
            'code' => $ref
        ));
        $refcontrol = $refcontrol->rowCount();

        if (!isset($_SESSION['referral']))
        {

            $row = $conn->prepare('SELECT * FROM clients WHERE referral_code=:code');
            $row->execute(array(
                'code' => $ref
            ));
            $row = $row->fetch(PDO::FETCH_ASSOC);

            $update = $conn->prepare("UPDATE clients SET total_click=:click WHERE referral_code=:code ");
            $update->execute(array(
                "code" => $ref,
                "click" => $row["total_click"] + 1
            ));
        }
        if ($refcontrol)
        {
            $_SESSION['referral'] = $ref;

            echo 'a';
        }
        echo 'aa';
    }
    echo 'aaa';

    header('Location:' . site_url());
}

if (!file_exists(controller($route[0])))
{
    $route[0] = '404';
}

$ip = GetIP();

if (route(0) != 'admin' && $settings['site_maintenance'] == 1 && $user["username"] != "medyabenim"):
    include 'themes/maintenance.php';
    die();
endif;
if ($settings['service_list'] == 2):
    $serviceList = 1;
endif;
if ($settings['register_page'] == 2):
    $registerPage = 1;
endif;

require controller($route[0]);

if (isset($_SESSION['recaptcha']))
{
    $captcha = true;
}


$menu = $conn->prepare('SELECT * FROM menu WHERE id=:id');
$menu->execute(array(
    'id' => 5
));
$menu = $menu->fetch(PDO::FETCH_ASSOC);

if ($_SESSION['neira_userlogin'] != 1)
{
    if (countRow(['table' => 'blogs']) > 0 && $menu['status'] == 2)
    {
        $blogPage = true;
    }
    else
    {
        $blogPage = false;
    }
}
else
{
    if (countRow(['table' => 'blogs']) > 0 && $menu['public'] == 2)
    {
        $blogPage = true;
    }
    else
    {
        $blogPage = false;
    }
}


$menu = $conn->prepare('SELECT * FROM menu WHERE id=:id');
$menu->execute(array(
    'id' => 2
));
$menu = $menu->fetch(PDO::FETCH_ASSOC);

if ($_SESSION['neira_userlogin'] != 1)
{
    if ($menu['status'] == 2)
    {
        $apiPage = true;
    }
    else
    {
        $apiPage = false;
    }
}
else
{
    if ($menu['public'] == 2)
    {
        $apiPage = true;
    }
    else
    {
        $apiPage = false;
    }
}


$menu = $conn->prepare('SELECT * FROM menu WHERE id=:id');
$menu->execute(array(
    'id' => 4
));
$menu = $menu->fetch(PDO::FETCH_ASSOC);

if ($_SESSION['neira_userlogin'] != 1)
{
    if ($menu['status'] == 2)
    {
        $faqPage = true;
    }
    else
    {
        $faqPage = false;
    }
}
else
{
    if ($menu['public'] == 2)
    {
        $faqPage = true;
    }
    else
    {
        $faqPage = false;
    }
}


$menu = $conn->prepare('SELECT * FROM menu WHERE id=:id');
$menu->execute(array(
    'id' => 3
));
$menu = $menu->fetch(PDO::FETCH_ASSOC);

if ($_SESSION['neira_userlogin'] != 1)
{
    if ($menu['status'] == 2)
    {
        $termsPage = true;
    }
    else
    {
        $termsPage = false;
    }
}
else
{
    if ($menu['public'] == 2)
    {
        $termsPage = true;
    }
    else
    {
        $termsPage = false;
    }
}


if (route(0) == 'auth'):
    $active_menu = route(0);
else:
    $active_menu = route(0);
endif;

if (route(0) != 'admin' && route(0) != 'ajax_data')
{
    $languages = $conn->prepare('SELECT * FROM languages WHERE language_type=:type');
    $languages->execute(array(
        'type' => 2
    ));
    $languages = $languages->fetchAll(PDO::FETCH_ASSOC);
    $languagesL = [];
    foreach ($languages as $language)
    {
        $l['name'] = $language['language_name'];
        $l['code'] = $language['language_code'];
        if (isset($_SESSION['lang']) && $language['language_code'] == $_SESSION['lang'])
        {
            $l['active'] = 1;
        }
        elseif (!$_SESSION['lang'])
        {
            $l['active'] = $language['default_language'];
        }
        else
        {
            $l['active'] = 0;
        }
        array_push($languagesL, $l);
    }

    if (!$templateDir)
    {
        $templateDir = route($routeType);
    }
    if ($templateDir == 'login'):
        $contentGet = 'auth';
    else:
        $contentGet = $templateDir;
    endif;

    $content = $conn->prepare('SELECT * FROM pages WHERE page_get=:get ');
    $content->execute(array(
        'get' => $contentGet
    ));
    $content = $content->fetch(PDO::FETCH_ASSOC);
    $content = $content['page_content'];

    $orderssss = $conn->prepare('SELECT * FROM orders WHERE order_error=:error ORDER BY order_id  DESC');
    $orderssss->execute(array(
        'error' => '-'
    ));
    $orderssss = $orderssss->fetch(PDO::FETCH_ASSOC);
    $ordersCount = $orderssss["order_id"];

    $headerCode = $settings["header_code"];

    if ($_SESSION['neira_userlogin'] != 1 || $user['client_type'] == 1)
    {

        echo $twig->render($templateDir . '.twig', array(
            'site' => ['url' => URL,
            'favicon' => $settings['favicon'],
            'logo' => $settings['site_logo'],
            'site_name' => $settings['site_name'],
            'currency' => $currency,
            'languages' => $languagesL],
            'styleList' => $stylesheet['stylesheets'],
            'scriptList' => $stylesheet['scripts'],
            'captchaKey' => $settings['recaptcha_key'],
            'captcha' => $captcha,
            'resetStep' => $resetStep,
            'resetPage' => $resetPage,
            'blogPage' => $blogPage,
            'panelSelling' => $panelSelling,
            'ticketPage' => $ticketPage,
            'apiPage' => $apiPage,
            'faqPage' => $faqPage,
            'termsPage' => $termsPage,
            'serviceCategory' => $categories,
            'categories' => $categories,
            'error' => $error,
            'errorText' => $errorText,
            'success' => $success,
            'servicesPage' => $serviceList,
            'registerPage' => $registerPage,
            'resetType' => $resetType,
            'successText' => $successText,
            'title' => $title,
            'keywords' => $settings['site_keywords'],
            'description' => $settings['site_description'],
            'data' => $_SESSION['data'],
            'settings' => $settings,
            'search' => urldecode($_GET['search']) ,
            'active_menu' => $active_menu,
            'avarageTime' => $avarageTime,
            'ordersCount' => $ordersCount,
            'status' => $route[1],
            'pagination' => $paginationArr,
            'blogList' => $blogList,
            'contentText' => $content,
            'headerCode' => $headerCode,
            'footerCode' => $settings['custom_footer'],
            'lang' => $languageArray,
            'timezones' => $timezones
        ));

    }
    else
    {

        $uye_id = $user['client_id'];
		 $ref_code = $user['referral_code'];
        $refCount = countRow(["table"=>"clients","where"=>["referral"=>$ref_code]]);

        if ($settings['panel_selling'] == 1)
        {
            $panelSelling = false;
        }
        elseif ($settings['panel_selling'] == 2)
        {
            $panelSelling = true;
        }

        if ($settings['referral'] == 1)
        {
            $referral = false;
        }
        elseif ($settings['referral'] == 2)
        {
            $referral = true;
        }

        if ($settings['neworder_terms'] == 2)
        {
            $neworder_terms = true;
        }
        else
        {
            $neworder_terms = false;
        }

        $dripfeedvarmi = $conn->query("SELECT * FROM orders WHERE client_id=$uye_id and dripfeed=2");
        if ($dripfeedvarmi->rowCount())
        {
            $dripfeedcount = 1;
        }
        else
        {
            $dripfeedcount = 0;
        }

        $subscriptionsvarmi = $conn->query("SELECT * FROM orders WHERE client_id=$uye_id and subscriptions_type=2");
        if ($subscriptionsvarmi->rowCount())
        {
            $subscriptionscount = 1;
        }
        else
        {
            $subscriptionscount = 0;
        }

        if ($settings['ticket_system'] == 2):
            $ticketPage = 1;
        endif;

        echo $twig->render($templateDir . '.twig', array(
            'site' => ['url' => URL,
            'favicon' => $settings['favicon'],
            'logo' => $settings['site_logo'],
            'site_name' => $settings['site_name'],
            'currency' => $currency,
            'languages' => $languagesL,
            'dripfeedcount' => $dripfeedcount,
            'subscriptionscount' => $subscriptionscount],
            'styleList' => $stylesheet['stylesheets'],
            'scriptList' => $stylesheet['scripts'],
            'captchaKey' => $settings['recaptcha_key'],
            'captcha' => $captcha,
            'resetPage' => $resetPage,
            'refCount' => $refCount,
            'blogPage' => $blogPage,
            'affiliates' => $referral,
            'panelSelling' => $panelSelling,
            'serviceCategory' => $categories,
            'categories' => $categories,
            'error' => $error,
            'errorText' => $errorText,
            'success' => $success,
            'servicesPage' => $serviceList,
            'registerPage' => $registerPage,
            'apiPage' => $apiPage,
            'neworderTerms' => $neworder_terms,
            'faqPage' => $faqPage,
            'termsPage' => $termsPage,
            'ticketPage' => $ticketPage,
            'resetType' => $resetType,
            'successText' => $successText,
            'title' => $title,
            'keywords' => $settings['site_keywords'],
            'description' => $settings['site_description'],
            'user' => $user,
            'data' => $_SESSION['data'],
            'newsList' => $newsList,
            'ordersCount' => $ordersCount,
            'settings' => $settings,
            'search' => urldecode($_GET['search']) ,
            'active_menu' => $active_menu,
            'ticketList' => $ticketList,
            'blogList' => $blogList,
            'messageList' => $messageList,
            'ticketCount' => new_ticket($user['client_id']) ,
            'avarageTime' => $avarageTime,
            'paymentsList' => $methodList,
            'bankPayment' => $bankPayment['method_type'],
            'bankList' => $bankList,
            'status' => $route[1],
            'orders' => $ordersList,
            'pagination' => $paginationArr,
            'contentText' => $content,
            'headerCode' => $headerCode,
            'footerCode' => $settings['custom_footer'],
            'verify' => $verify,
            'lang' => $languageArray,
            'timezones' => $timezones,
            'refillButton' => $refillButton,
            'cancelButton' => $cancelButton,
			"paymentHistory" => $paymentsHistory
        ));

    }

}
if (route(0) != 'neworder' && route(0) != 'ajax_data' && (route(0) != 'admin' && route(1) != 'services')):
    unset($_SESSION['data']);
endif;

if (route(0) != 'admin' && route(0) != 'ajax_data')
{

    $int1 = $conn->prepare('SELECT * FROM integrations WHERE status=:status && visibility=:visibility');
    $int1->execute(array(
        'status' => 2,
        'visibility' => 1
    ));

    if ($int1)
    {
        foreach ($int1 as $int)
        {
            echo $int['code'];
        }
    }

    if ($_SESSION['neira_userlogin'] != 1)
    {

        $int2 = $conn->prepare('SELECT * FROM integrations WHERE status=:status && visibility=:visibility');
        $int2->execute(array(
            'status' => 2,
            'visibility' => 2
        ));

        if ($int2)
        {
            foreach ($int2 as $int)
            {
                echo $int['code'];
            }
        }
    }

    if ($_SESSION['neira_userlogin'] == 1)
    {

        $int3 = $conn->prepare('SELECT * FROM integrations WHERE status=:status && visibility=:visibility');
        $int3->execute(array(
            'status' => 2,
            'visibility' => 3
        ));

        if ($int3)
        {
            foreach ($int3 as $int)
            {
                echo $int['code'];
            }
        }
    }
}

if ($settings['site_maintenance'] == 2 && $settings["cache"] == 2 && (route(0) == 'faq' || route(0) == 'terms' || route(0) == 'services' || route(0) == 'blog'))
{

    $sayfa_verisi = ob_get_contents();
    ob_end_flush();
    $dosya = fopen($dosya_yolu, 'w+');
    fwrite($dosya, $sayfa_verisi);
    fclose($dosya);

}

