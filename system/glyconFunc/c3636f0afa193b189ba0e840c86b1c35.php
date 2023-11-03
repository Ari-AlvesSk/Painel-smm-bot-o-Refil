<?php

function CreateApiKey($data)
{
    global $conn;
    $data = md5($data["email"] . $data["username"] . rand(9999, 2324332));
    $row = $conn->prepare("SELECT * FROM clients WHERE apikey=:key ");
    $row->execute(["key" => $data]);
    if ($row->rowCount()) {
        CreateApiKey();
    } else {
        return $data;
    }
}
function guardDeleteAllRoles()
{
    $update = $conn->prepare("UPDATE clients SET access=:access WHERE client_id=:c_id ");
    $update->execute(["c_id" => $user["client_id"], "access" => "{\"admin_access\":\"0\"}"]);
    header("Location:" . site_url(""));
}
function guardLogout()
{
    unset($_SESSION["neira_userid"]);
    unset($_SESSION["neira_userpass"]);
    unset($_SESSION["neira_userlogin"]);
    setcookie("u_id", $user["client_id"], time() - 604800, "/", NULL, NULL, true);
    setcookie("u_password", $user["password"], time() - 604800, "/", NULL, NULL, true);
    setcookie("u_login", "ok", time() - 604800, "/", NULL, NULL, true);
    setcookie("a_login", "ok", time() - 604800, "/", NULL, NULL, true);
    session_destroy();
    header("Location:" . site_url(""));
}
function replace_tr($text)
{
    $text = trim($text);
    $search = ["Ç", "ç", "Ğ", "ğ", "ı", "İ", "Ö", "ö", "Ş", "ş", "Ü", "ü", " ", ".", ",", "<", ">", "!"];
    $replace = ["c", "c", "g", "g", "i", "i", "o", "o", "s", "s", "u", "u", "-", "", "", "", "", ""];
    $new_text = str_replace($search, $replace, $text);
    return $new_text;
}
function convertSecToStr($secs)
{
    $output = "";
    if (86400 <= $secs) {
        $days = floor($secs / 86400);
        $secs = $secs % 86400;
        $output = $days . " Day";
        if ($days != 1) {
            $output .= "";
        }
        if (0 < $secs) {
            $output .= ", ";
        }
    }
    if (3600 <= $secs) {
        $hours = floor($secs / 3600);
        $secs = $secs % 3600;
        $output .= $hours . " Hour";
        if ($hours != 1) {
            $output .= "";
        }
        if (0 < $secs) {
            $output .= ", ";
        }
    }
    if (60 <= $secs) {
        $minutes = floor($secs / 60);
        $secs = $secs % 60;
        $output .= $minutes . " Minutes";
        if ($minutes != 1) {
            $output .= "";
        }
        if (0 < $secs) {
            $output .= " ";
        }
    }
    return $output;
}
function ortalama($array)
{
    $toplam = 0;
    $sayi = count($array);
    foreach ($array as $ort) {
        if (is_numeric($ort)) {
            $toplam += $ort;
        } else {
            $sayi--;
        }
    }
    if ($sayi) {
        $islem = $toplam / $sayi;
        return $islem;
    }
    return "NaN";
}
function createReferral()
{
    $karakterler = "1234567890abcdefghijKLMNOPQRSTuvwxyzABCDEFGHIJklmnopqrstUVWXYZ0987654321";
    $sifre = "";
    for ($i = 0; $i < 5; $i++) {
        $sifre = $karakterler[rand() % 72];
    }
    return $sifre;
}
function createPaymentCode()
{
    global $conn;
    $row = $conn->prepare("SELECT * FROM payments WHERE payment_method!=:method ORDER BY payment_privatecode DESC LIMIT 1 ");
    $row->execute(["method" => 4]);
    $row = $row->fetch(PDO::FETCH_ASSOC);
    return $row["payment_privatecode"];
}
function generate_shopier_form($data)
{
    $api_key = $data->apikey;
    $secret = $data->apisecret;
    $user_registered = date("Y.m.d");
    $time_elapsed = time() - strtotime($user_registered);
    $buyer_account_age = (int) ($time_elapsed / 86400);
    $currency = 0;
    $dataArray = $data;
    $productinfo = $data->item_name;
    $producttype = 1;
    $productinfo = str_replace("\"", "", $productinfo);
    $productinfo = str_replace("\"", "", $productinfo);
    $current_language = 0;
    $current_lan = 0;
    $modul_version = "1.0.4";
    srand(time(NULL));
    $random_number = rand(1000000, 9999999);
    $args = ["API_key" => $api_key, "website_index" => $data->website_index, "platform_order_id" => $data->order_id, "product_name" => $productinfo, "product_type" => $producttype, "buyer_name" => $data->buyer_name, "buyer_surname" => $data->buyer_surname, "buyer_email" => $data->buyer_email, "buyer_account_age" => $buyer_account_age, "buyer_id_nr" => 0, "buyer_phone" => $data->buyer_phone, "billing_address" => $data->billing_address, "billing_city" => $data->city, "billing_country" => "TR", "billing_postcode" => "", "shipping_address" => $data->billing_address, "shipping_city" => $data->city, "shipping_country" => "TR", "shipping_postcode" => "", "total_order_value" => $data->ucret, "currency" => $currency, "platform" => 0, "is_in_frame" => 1, "current_language" => $current_lan, "modul_version" => $modul_version, "random_nr" => $random_number];
    $data = $args["random_nr"] . $args["platform_order_id"] . $args["total_order_value"] . $args["currency"];
    $signature = hash_hmac("SHA256", $data, $secret, true);
    $signature = base64_encode($signature);
    $args["signature"] = $signature;
    $args_array = [];
    foreach ($args as $key => $value) {
        $args_array[] = "<input type='hidden' name='" . $key . "' value='" . $value . "'/>";
    }
    if (!empty($dataArray->apikey) && !empty($dataArray->apisecret) && !empty($dataArray->website_index)) {
        $_SESSION["data"]["payment_shopier"] = true;
        return "<html> <!doctype html><head> <meta charset=\"UTF-8\"> <meta content=\"True\" name=\"HandheldFriendly\"> <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n      <meta name=\"robots\" content=\"noindex, nofollow, noarchive\" />\n      <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, user-scalable=0\" /> <title lang=\"en\">Secure Payment Page</title><body><head>\n      <form action=\"https://www.shopier.com/ShowProduct/api_pay4.php\" method=\"post\" id=\"shopier_payment_form\" style=\"display: none\">" . implode("", $args_array) . "<script>setInterval(function(){document.getElementById(\"shopier_payment_form\").submit();},2000)</script></form></body></html>";
    }
}
function weePayMobile()
{
    $mobile = false;
    $useragent = $_SERVER["HTTP_USER_AGENT"];
    if (preg_match("/(android|bb\\d+|meego).+mobile|avantgo|bada\\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i", $useragent) || preg_match("/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\\-(n|u)|c55\\/|capi|ccwa|cdm\\-|cell|chtm|cldc|cmd\\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\\-s|devi|dica|dmob|do(c|p)o|ds(12|\\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\\-|_)|g1 u|g560|gene|gf\\-5|g\\-mo|go(\\.w|od)|gr(ad|un)|haie|hcit|hd\\-(m|p|t)|hei\\-|hi(pt|ta)|hp( i|ip)|hs\\-c|ht(c(\\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\\-(20|go|ma)|i230|iac( |\\-|\\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\\/)|klon|kpt |kwc\\-|kyo(c|k)|le(no|xi)|lg( g|\\/(k|l|u)|50|54|\\-[a-w])|libw|lynx|m1\\-w|m3ga|m50\\/|ma(te|ui|xo)|mc(01|21|ca)|m\\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\\-2|po(ck|rt|se)|prox|psio|pt\\-g|qa\\-a|qc(07|12|21|32|60|\\-[2-7]|i\\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\\-|oo|p\\-)|sdk\\/|se(c(\\-|0|1)|47|mc|nd|ri)|sgh\\-|shar|sie(\\-|m)|sk\\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\\-|v\\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\\-|tdg\\-|tel(i|m)|tim\\-|t\\-mo|to(pl|sh)|ts(70|m\\-|m3|m5)|tx\\-9|up(\\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\\-|your|zeto|zte\\-/i", substr($useragent, 0, 4))) {
        $mobile = true;
    }
    return $mobile;
}
function username_check($username)
{
    if (preg_match("/^[a-z\\d_]{4,32}\$/i", $username)) {
        $validate = true;
    } else {
        $validate = false;
    }
    return $validate;
}
function email_check($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $validate = true;
    } else {
        $validate = false;
    }
    return $validate;
}
function userdata_check($where, $data)
{
    global $conn;
    $row = $conn->prepare("SELECT * FROM clients WHERE " . $where . "=:data ");
    $row->execute(["data" => $data]);
    if ($row->rowCount()) {
        $validate = true;
    } else {
        $validate = false;
    }
    return $validate;
}
function userlogin_check($username, $pass)
{
    global $conn;
    $row = $conn->prepare("SELECT * FROM clients WHERE username=:username && password=:password ");
    $row->execute(["username" => $username, "password" => md5(sha1(md5($pass)))]);
    if ($row->rowCount()) {
        $validate = true;
    } else {
        $validate = false;
    }
    return $validate;
}
function service_price($service)
{
    global $conn;
    global $user;
    $row = $conn->prepare("SELECT * FROM clients_price WHERE service_id=:s_id && client_id=:c_id ");
    $row->execute(["s_id" => $service, "c_id" => $user["client_id"]]);
    if ($row->rowCount()) {
        $row = $row->fetch(PDO::FETCH_ASSOC);
        $price = $row["service_price"];
    } else {
        $row = $conn->prepare("SELECT * FROM services WHERE service_id=:id");
        $row->execute(["id" => $service]);
        $row = $row->fetch(PDO::FETCH_ASSOC);
        $price = $row["service_price"];
    }
    return $price;
}
function client_price($service, $userid)
{
    global $conn;
    global $user;
    $row = $conn->prepare("SELECT * FROM clients_price WHERE service_id=:s_id && client_id=:c_id ");
    $row->execute(["s_id" => $service, "c_id" => $userid]);
    if ($row->rowCount()) {
        $row = $row->fetch(PDO::FETCH_ASSOC);
        $price = $row["service_price"];
    } else {
        $row = $conn->prepare("SELECT * FROM services WHERE service_id=:id");
        $row->execute(["id" => $service]);
        $row = $row->fetch(PDO::FETCH_ASSOC);
        $price = $row["service_price"];
    }
    return $price;
}
function open_ticket($user)
{
    global $conn;
    $row = $conn->prepare("SELECT * FROM tickets WHERE client_id=:client && status=:status ");
    $row->execute(["client" => $user, "status" => "pending"]);
    $validate = $row->rowCount();
    return $validate;
}
function open_bankpayment($user)
{
    global $conn;
    $row = $conn->prepare("SELECT * FROM payments WHERE client_id=:client && payment_status=:status && payment_method=:method ");
    $row->execute(["client" => $user, "status" => 1, "method" => 6]);
    $validate = $row->rowCount();
    return $validate;
}
function new_ticket($user)
{
    global $conn;
    $row = $conn->prepare("SELECT * FROM tickets WHERE client_id=:client && support_new=:new ");
    $row->execute(["client" => $user, "new" => 2]);
    $validate = $row->rowCount();
    return $validate;
}
function countRow($data)
{
    global $conn;
    $where = "";
    if ($data["where"]) {
        $where = "WHERE ";
        foreach ($data["where"] as $key => $value) {
            $where .= " " . $key . "=:" . $key . " && ";
            $execute[$key] = $value;
        }
        $where = substr($where, 0, -3);
    } else {
        $execute[] = "";
    }
    $row = $conn->prepare("SELECT * FROM " . $data["table"] . " " . $where . " ");
    $row->execute($execute);
    $validate = $row->rowCount();
    return $validate;
}
function getRows($data)
{
    global $conn;
    $where = "";
    $order = "";
    $order = "";
    $limit = "";
    $execute[] = "";
    if ($data["where"]) {
        $where = "WHERE ";
        foreach ($data["where"] as $key => $value) {
            $where .= " " . $key . "=:" . $key . " && ";
            $execute[$key] = $value;
        }
        $where = substr($where, 0, -3);
    }
    if ($data["order"]) {
        $order = "ORDER BY " . $data["order"] . " " . $data["order_type"];
    }
    if ($data["limit"]) {
        $limit = "LIMIT " . $data["limit"];
    }
    $row = $conn->prepare("SELECT * FROM " . $data["table"] . " " . $where . " " . $order . " " . $limit . " ");
    $row->execute($execute);
    if ($row->rowCount()) {
        $rows = $row->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $rows = [];
    }
    return $rows;
}
function getRow($data)
{
    global $conn;
    $where = "WHERE ";
    foreach ($data["where"] as $key => $value) {
        $where .= " " . $key . "=:" . $key . " && ";
        $execute[$key] = $value;
    }
    $where = substr($where, 0, -3);
    $row = $conn->prepare("SELECT * FROM " . $data["table"] . " " . $where . " ");
    $row->execute($execute);
    if ($row->rowCount()) {
        $row = $row->fetch(PDO::FETCH_ASSOC);
    } else {
        $row = [];
    }
    return $row;
}
function statutoTR($status)
{
    switch ($status) {
        case "pending":
            $statu = "pending";
            break;
        case "inprogress":
            $statu = "inprogress";
            break;
        case "completed":
            $statu = "completed";
            break;
        case "partial":
            $statu = "partial";
            break;
        case "processing":
            $statu = "processing";
            break;
        case "canceled":
            $statu = "canceled";
            break;
        default:
            return $statu;
    }
}
function dripfeedstatutoTR($status)
{
    switch ($status) {
        case "active":
            $statu = "active";
            break;
        case "canceled":
            $statu = "canceled";
            break;
        case "completed":
            $statu = "completed";
            break;
        default:
            return $statu;
    }
}
function ticketStatu($status)
{
    switch ($status) {
        case "closed":
            $statu = "closed";
            break;
        case "answered":
            $statu = "answered";
            break;
        case "pending":
            $statu = "pending";
            break;
        default:
            return $statu;
    }
}
function subscriptionstatutoTR($status)
{
    switch ($status) {
        case "active":
            $statu = "active";
            break;
        case "canceled":
            $statu = "canceled";
            break;
        case "completed":
            $statu = "completed";
            break;
        case "paused":
            $statu = "paused";
            break;
        case "expired":
            $statu = "expired";
            break;
        case "limit":
            $statu = "limit";
            break;
        default:
            return $statu;
    }
}
function serviceTypeGetList($type)
{
    switch ($type) {
        case "Default":
            $service_type = 1;
            break;
        case "Package":
            $service_type = 2;
            break;
        case "Custom Comments":
            $service_type = 3;
            break;
        case "Custom Comments Package":
            $service_type = 4;
            break;
        case "Mentions":
            $service_type = 5;
            break;
        case "Mentions with hashtags":
            $service_type = 6;
            break;
        case "Mentions custom list":
            $service_type = 7;
            break;
        case "Mentions custom list":
            $service_type = "8";
            break;
        case "Mentions user followers":
            $service_type = 9;
            break;
        case "Mentions media likers":
            $service_type = 10;
            break;
        case "Subscriptions":
            $service_type = 11;
            break;
        default:
            return $service_type;
    }
}
function array_group_by($arr, $key)
{
    if (!is_string($key) && !is_int($key) && !is_float($key) && !is_callable($key)) {
        trigger_error("array_group_by(): The key should be a string, an integer, a float, or a function", 256);
    }
    $isFunction = !is_string($key) && is_callable($key);
    $grouped = [];
    foreach ($arr as $value) {
        $groupKey = NULL;
        if ($isFunction) {
            $groupKey = $key($value);
        } else {
            if (is_object($value)) {
                $groupKey = $value->{$key};
            } else {
                $groupKey = $value[$key];
            }
        }
        $grouped[$groupKey][] = $value;
    }
    if (2 < func_num_args()) {
        $args = func_get_args();
        foreach ($grouped as $groupKey => $value) {
            $params = array_merge([$value], array_slice($args, 2, func_num_args()));
            $grouped[$groupKey] = call_user_func_array("array_group_by", $params);
        }
    }
    return $grouped;
}
function force_download($file)
{
    if (isset($file) && file_exists($file)) {
        header("Content-length: " . filesize($file));
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"" . $file . "\"");
        readfile((int) $file);
    } else {
        echo "No file selected";
    }
}
function dayPayments($day, $ay, $year, $extra = NULL)
{
    global $conn;
    if (!empty($extra["methods"])) {
        if (count($extra["methods"])) {
            $where = "&& ( ";
            foreach ($extra["methods"] as $method) {
                $where .= "payment_method='" . $method . "' || ";
            }
            $where = substr($where, 0, -3);
            $where .= ") ";
        } else {
            $where = "";
        }
    }
    $first = $year . "-" . $ay . "-" . $day . " 00:00:00";
    $last = $year . "-" . $ay . "-" . $day . " 23:59:59";
    $row = $conn->query("SELECT SUM(payment_amount) FROM payments WHERE payment_delivery='2' && payment_status='3' && payment_create_date<='" . $last . "' && payment_create_date>='" . $first . "' " . $where . "  ")->fetch(PDO::FETCH_ASSOC);
    $charge = $row["SUM(payment_amount)"];
    return number_format($charge, 2, ".", ",");
}
function monthPayments($ay, $year, $extra = NULL)
{
    global $conn;
    if (!empty($extra["methods"])) {
        if (count($extra["methods"])) {
            $where = "&& ( ";
            foreach ($extra["methods"] as $method) {
                $where .= "payment_method='" . $method . "' || ";
            }
            $where = substr($where, 0, -3);
            $where .= ") ";
        } else {
            $where = "";
        }
    }
    $first = $year . "-" . $ay . "-1 00:00:00";
    $last = $year . "-" . $ay . "-31 23:59:59";
    $row = $conn->query("SELECT SUM(payment_amount) FROM payments WHERE payment_delivery='2' && payment_status='3' && payment_create_date<='" . $last . "' && payment_create_date>='" . $first . "' " . $where . " ")->fetch(PDO::FETCH_ASSOC);
    $charge = $row["SUM(payment_amount)"];
    return number_format($charge, 2, ".", ",");
}
function dayCharge($day, $ay, $year, $extra = NULL)
{
    global $conn;
    if (!empty($extra["status"])) {
        if (count($extra["status"])) {
            $where = "&& ( ";
            if (in_array("cron", $extra["status"])) {
                $where .= "order_detail='cronpending' || ";
            }
            if (in_array("fail", $extra["status"])) {
                $where .= "order_error!='-' || ";
            }
            foreach ($extra["status"] as $statu) {
                if ($statu != "cron" || $statu != "fail") {
                    $where .= "order_status='" . $statu . "' || ";
                }
            }
            $where = substr($where, 0, -3);
            $where .= ") ";
        } else {
            $where = "";
        }
    }
    if (!empty($_POST["services"]) && count($_POST["services"])) {
        $where .= "&& ( ";
        foreach ($extra["services"] as $service) {
            $where .= " service_id='" . $service . "' || ";
        }
        $where = substr($where, 0, -3);
        $where .= ") ";
    }
    $first = $year . "-" . $ay . "-" . $day . " 00:00:00";
    $last = $year . "-" . $ay . "-" . $day . " 23:59:59";
    $row = $conn->query("SELECT SUM(order_charge) FROM orders WHERE order_create<='" . $last . "' && order_create>='" . $first . "' && dripfeed='1' && subscriptions_type='1'   " . $where . "   ")->fetch(PDO::FETCH_ASSOC);
    $charge = $row["SUM(order_charge)"];
    return number_format($charge, 2, ".", ",");
}
function monthCharge($month, $year, $extra = NULL)
{
    global $conn;
    if (!empty($extra["status"])) {
        if (count($extra["status"])) {
            $where = "&& ( ";
            if (in_array("cron", $extra["status"])) {
                $where .= "order_detail='cronpending' || ";
            }
            if (in_array("fail", $extra["status"])) {
                $where .= "order_error!='-' || ";
            }
            foreach ($extra["status"] as $statu) {
                if ($statu != "cron" || $statu != "fail") {
                    $where .= "order_status='" . $statu . "' || ";
                }
            }
            $where = substr($where, 0, -3);
            $where .= ")";
        } else {
            $where = "";
        }
    }
    if (!empty($_POST["services"]) && count($_POST["services"])) {
        $where .= "&& ( ";
        foreach ($extra["services"] as $service) {
            $where .= " service_id='" . $service . "' || ";
        }
        $where = substr($where, 0, -3);
        $where .= ") ";
    }
    $first = $year . "-" . $month . "-1 00:00:00";
    $last = $year . "-" . $month . "-31 23:59:59";
    $row = $conn->query("SELECT SUM(order_charge) FROM orders WHERE order_create<='" . $last . "' && order_create>='" . $first . "'  && dripfeed='1' && subscriptions_type='1' " . $where . "   ")->fetch(PDO::FETCH_ASSOC);
    $charge = $row["SUM(order_charge)"];
    return number_format($charge, 2, ".", ",");
}
function monthChargeNet($month, $year, $extra = NULL)
{
    global $conn;
    if (!empty($extra["status"])) {
        if (count($extra["status"])) {
            $where = "&& ( ";
            if (in_array("cron", $extra["status"])) {
                $where .= "order_detail='cronpending' || ";
            }
            if (in_array("fail", $extra["status"])) {
                $where .= "order_error!='-' || ";
            }
            foreach ($extra["status"] as $statu) {
                if ($statu != "cron" || $statu != "fail") {
                    $where .= "order_status='" . $statu . "' || ";
                }
            }
            $where = substr($where, 0, -3);
            $where .= ")";
        } else {
            $where = "";
        }
    }
    if (!empty($_POST["services"]) && count($_POST["services"])) {
        $where .= "&& ( ";
        foreach ($extra["services"] as $service) {
            $where .= " service_id='" . $service . "' || ";
        }
        $where = substr($where, 0, -3);
        $where .= ") ";
    }
    $first = $year . "-" . $month . "-1 00:00:00";
    $last = $year . "-" . $month . "-31 23:59:59";
    $row = $conn->query("SELECT SUM(order_profit) FROM orders WHERE order_create<='" . $last . "' && order_create>='" . $first . "' && dripfeed='1' && subscriptions_type='1' && order_api!='0' " . $where . "  ")->fetch(PDO::FETCH_ASSOC);
    $row2 = $conn->query("SELECT SUM(order_charge) FROM orders WHERE order_create<='" . $last . "' && order_create>='" . $first . "' && dripfeed='1' && subscriptions_type='1'  " . $where . "  ")->fetch(PDO::FETCH_ASSOC);
    $charge = $row2["SUM(order_charge)"] - $row["SUM(order_profit)"];
    return number_format($charge, 2, ".", ",");
}

$token_key_moto = "erkansiksinseni";
$keys_key_moto  = md5(base64_encode(md5("glycon". base64_encode(DINAMICLISANCE. md5("$token_key_moto")))));
function dayOrders($day, $month, $year, $extra = NULL)
{
    global $conn;
    if (!empty($extra["status"])) {
        if (count($extra["status"])) {
            $where = "&& ( ";
            if (in_array("cron", $extra["status"])) {
                $where .= "order_detail='cronpending' || ";
            }
            if (in_array("fail", $extra["status"])) {
                $where .= "order_error!='-' || ";
            }
            foreach ($extra["status"] as $statu) {
                if ($statu != "cron" || $statu != "fail") {
                    $where .= "order_status='" . $statu . "' || ";
                }
            }
            $where = substr($where, 0, -3);
            $where .= ") ";
        } else {
            $where = "";
        }
    }
    if (!empty($extra["status"]) && count($_POST["services"])) {
        $where .= "&& ( ";
        foreach ($extra["services"] as $service) {
            $where .= " service_id='" . $service . "' || ";
        }
        $where = substr($where, 0, -3);
        $where .= ") ";
    }
    $first = $year . "-" . $month . "-" . $day . " 00:00:00";
    $last = $year . "-" . $month . "-" . $day . " 23:59:59";
    return $row = $conn->query("SELECT order_id FROM orders WHERE order_create<='" . $last . "' && order_create>='" . $first . "' " . $where . " ")->rowCount();
}
function monthOrders($month, $year, $extra = NULL)
{
    global $conn;
    if (!empty($extra["status"])) {
        if (count($extra["status"])) {
            $where = "&& ( ";
            if (in_array("cron", $extra["status"])) {
                $where .= "order_detail='cronpending' || ";
            }
            if (in_array("fail", $extra["status"])) {
                $where .= "order_error!='-' || ";
            }
            foreach ($extra["status"] as $statu) {
                if ($statu != "cron" || $statu != "fail") {
                    $where .= "order_status='" . $statu . "' || ";
                }
            }
            $where = substr($where, 0, -3);
            $where .= ")";
        } else {
            $where = "";
        }
    }
    if (!empty($_POST["services"]) && count($_POST["services"])) {
        $where .= "&& ( ";
        foreach ($extra["services"] as $service) {
            $where .= " service_id='" . $service . "' || ";
        }
        $where = substr($where, 0, -3);
        $where .= ") ";
    }
    $first = $year . "-" . $month . "-1 00:00:00";
    $last = $year . "-" . $month . "-31 23:59:59";
    return $row = $conn->query("SELECT order_id FROM orders WHERE order_create<='" . $last . "' && order_create>='" . $first . "' " . $where . " ")->rowCount();
}
function priceFormat($price)
{
    $priceExplode = explode(".", $price);
    if ($priceExplode[1]) {
        if (strlen($priceExplode[1]) == 1) {
            return $price . "0";
        }
        return $price;
    }
    return $price . ".00";
}
function title2($lang = "tr", $key, $key2 = "")
{
    $convertLang = ["tr" => ["index" => "Home page", "clients" => "clients", "orders" => "orders", "dripfeeds" => "Drip-feeds", "tasks" => "Tasks", "subscriptions" => "subscriptions", "services" => "services", "payments" => ["online" => "online", "bank" => "Bank"], "tickets" => "tickets", "reports" => "reports", "appearance" => ["pages" => "appearance", "blog" => "Blog", "menu" => "Menü", "themes" => "themes", "language" => "language"], "settings" => ["general" => "Genelral settings", "providers" => "providers", "payment-methods" => "payment methods", "bank-accounts" => "Bank Account", "modules" => "modules", "integrations" => "integrations", "subject" => "subject", "alert" => "alert", "payment-bonuses" => "bonuses"], "child-panels" => "Child Panels", "logs" => "Logs", "provider_logs" => "provider logs", "guard_logs" => "guard logs", "account" => "account"], "en" => ["index" => "Home"]];
    if ($key2 != "") {
        return $convertLang[$lang][$key][$key2];
    }
    return $convertLang[$lang][$key];
}

function rateSync($sayi, $yuzde)
{
    return $sayi * $yuzde / 100;
}


?>