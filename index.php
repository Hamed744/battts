<?php
// ===================================================================
// ALPHA TTS BOT - RENDER.COM - FINAL WITH LOCKING SYSTEM
// Version: 4.3 - Made referral link clickable in caption
// ===================================================================

define('TELEGRAM_BOT_TOKEN', getenv('TELEGRAM_BOT_TOKEN'));
define('RENDER_API_URL', getenv('RENDER_API_URL'));
define('INTERNAL_API_SECRET', getenv('INTERNAL_API_SECRET'));
define('ZARINPAL_MERCHANT_ID', getenv('ZARINPAL_MERCHANT_ID'));
define('BOT_USERNAME', getenv('BOT_USERNAME') ?: 'Alphattsbot');
define('SUPPORT_USERNAME', getenv('SUPPORT_USERNAME') ?: 'ezmarynoori');
define('USER_API_URL', getenv('USER_API_URL'));
define('USER_API_SECRET', getenv('USER_API_SECRET'));
define('CALLBACK_URL', 'https://' . ($_SERVER['HTTP_HOST'] ?? 'YOUR_APP_NAME.onrender.com') . '/');

ignore_user_abort(true);
set_time_limit(600); 

define('SUBSCRIPTION_PLANS', [
    '1_month' => ['name' => 'یک ماهه نامحدود', 'price' => 150000, 'duration' => '+1 month'],
    '6_months' => ['name' => 'شش ماهه نامحدود', 'price' => 497000, 'duration' => '+6 months'],
    '1_year' => ['name' => 'یک ساله نامحدود', 'price' => 799000, 'duration' => '+1 year']
]);
define('SPEAKER_PAGES', [
    'https://uploadkon.ir/uploads/c5be15_25IMG-۲۰۲۵۰۹۱۵-۱۱۰۷۱۷.jpg',
    'https://uploadkon.ir/uploads/298515_25IMG-۲۰۲۵۰۹۱۵-۱۱۰۷۳۵.jpg',
    'https://uploadkon.ir/uploads/ffbd15_25IMG-۲۰۲۵۰۹۱۵-۱۱۰۷۵۰.jpg',
    'https://uploadkon.ir/uploads/9df915_25IMG-۲۰۲۵۰۹۱۵-۱۱۰۸۰۶.jpg'
]);
$speakers = [
    ["id" => "Charon", "name" => "شهاب (مرد)", "sticker_id" => "CAACAgUAAxkBAAEYPQNox-KKZX3zq9MDLncxvJ1iJ6TgpwACnBkAAkNIQFba6SyfZFfZzDYE"], ["id" => "Zephyr", "name" => "آوا (زن)", "sticker_id" => "CAACAgUAAxkBAAEYPQFox-J7LoSkDhyIi-QB1R5Lo8mGYwACYxgAAsfpOVZj5bqFIcXJ6zYE"], ["id" => "Achird", "name" => "نوید (مرد)", "sticker_id" => "CAACAgUAAxkBAAEYPQ1ox-MfiSopQvDlUs0EhQpi62XHrAAC9B8AAha-QVaIWTf4YBiqmTYE"], ["id" => "Zubenelgenubi", "name" => "آرمان (مرد)", "sticker_id" => "CAACAgUAAxkBAAEYPRFox-NBcq6VkcXvuA_4Igj1PEkgYQACKigAAi9PQVZ4veRoeyfbhDYE"], ["id" => "Vindemiatrix", "name" => "مهسا (زن)", "sticker_id" => "CAACAgUAAxkBAAEYPRVox-NS3XGVPe9wdW1uoJQaJ11BkQAC0hYAAgNIQVagnFIpYX_8dDYE"], ["id" => "Sadachbia", "name" => "سامان (مرد)", "sticker_id" => "CAACAgUAAxkBAAEYPRdox-NgYIsVn83WVl0ZC08CBEmcegACyxgAAgN9QVZhh8TDp0TCVjYE"], ["id" => "Sadaltager", "name" => "آرش (مرد)", "sticker_id" => "CAACAgUAAxkBAAEYPRtox-N4UzJLw6QcQ5DRRUEgU7qgvAACNRkAArrjQVZxH2DWg2K2HzYE"], ["id" => "Sulafat", "name" => "شبنم (زن)", "sticker_id" => "CAACAgUAAxkBAAEYPR1ox-OKzExg_EimiDnOCLoGDoHRpAACfxcAAlVjQVaAXiad1E70NzYE"], ["id" => "Laomedeia", "name" => "سحر (زن)", "sticker_id" => "CAACAgUAAxkBAAEYPSFox-OWBAe4mAuVX5PDfR86EVO_qQACGxoAAj26OFYiFItngQOiwDYE"], ["id" => "Achernar", "name" => "مریم (زن)", "sticker_id" => "CAACAgUAAxkBAAEYPSNox-OjinI-hCvP4f-aPnG3A27rDgACUxsAArlOQVbstmCZxsINJDYE"], ["id" => "Alnilam", "name" => "بهرام (مرد)", "sticker_id" => "CAACAgUAAxkBAAEYPSVox-OyDI-91uo0a90SKP_gl9LLLQACTBgAArpHQVY1oMYrjKmv9zYE"], ["id" => "Schedar", "name" => "نیکان (مرد)", "sticker_id" => "CAACAgUAAxkBAAEYPSlox-PESJhB9qJjuYXmYgnbjojuwQACcRgAAgH4OFaBbAhRQcNxyjYE"], ["id" => "Gacrux", "name" => "فرناز (زن)", "sticker_id" => "CAACAgUAAxkBAAEYPStox-QO_vjSqb21cz7GPa5RnXMbuAACTBkAAkLQQFb4kttkGAvC2jYE"], ["id" => "Pulcherrima", "name" => "سارا (زن)", "sticker_id" => "CAACAgUAAxkBAAEYPS1ox-Qeqn6ibT148SCuccPonqh4ZQAC4R8AArzfOFazYzXm0gHxVTYE"], ["id" => "Umbriel", "name" => "مانی (مرد)", "sticker_id" => "CAACAgUAAxkBAAEYPS9ox-QuUcUAAeKyD7A1lT-HUhSsAAEiAAKSGQACKMxBViNIL1SGu68UNgQ"], ["id" => "Algieba", "name" => "آرتین (مرد)", "sticker_id" => "CAACAgUAAxkBAAEYPTFox-RETf15qxnaOdOlNB79SA_BRAACRR8AAtxHQFbx6c8T6RbULzYE"], ["id" => "Despina", "name" => "دلنواز (زن)", "sticker_id" => "CAACAgUAAxkBAAEYPTpox-RVvVtm4OLHqj4iJFStCFXKKQACshkAAkaUQFarMRijcz788TYE"], ["id" => "Erinome", "name" => "روژان (زن)", "sticker_id" => "CAACAgUAAxkBAAEYPT1ox-RmsM-QWebCkWquyRVpnRhDSgADHgACmC1AVjCg0Mzaz88nNgQ"], ["id" => "Algenib", "name" => "امید (مرد)", "sticker_id" => "CAACAgUAAxkBAAEYPT9ox-R5Eoc0kogVwdZ01oD81v1SPgACCRgAAh7vQVbMnlqtIazx1DYE"], ["id" => "Orus", "name" => "بردیا (مرد)", "sticker_id" => "CAACAgUAAxkBAAEYPUFox-SIPYzgBqWHmLcNZW5NX_uwoAACtBkAAvr2QVa0LxB9WplycjYE"], ["id" => "Aoede", "name" => "ترانه (زن)", "sticker_id" => "CAACAgUAAxkBAAEYPUNox-SZFgcFIWq9RNnTsmkvfcr6GwACWRYAAjKHQFYcaJS152bioTYE"], ["id" => "Callirrhoe", "name" => "نیکو (زن)", "sticker_id" => "CAACAgUAAxkBAAEYPUVox-SnEZHeH2-oyxpzu1l1ze9pgAACuxgAAolrQFbnNgOtUfj5ezYE"], ["id" => "Autonoe", "name" => "هستی (زن)", "sticker_id" => "CAACAgUAAxkBAAEYPUdox-S3o8JaBig8xJDhMvwziZBWGAACOBoAAmb6QFZJ3G1QTkEm0TYE"], ["id" => "Enceladus", "name" => "کامیار (مرد)", "sticker_id" => "CAACAgUAAxkBAAEYPUlox-THc7SxHNmBmlk-5yTa0KbjigACHhgAAmu0QFYa_SJCMtPREjYE"], ["id" => "Iapetus", "name" => "کیانوش (مرد)", "sticker_id" => "CAACAgUAAxkBAAEYPUtox-TZTWQTyMxoR3Z8bSEZEfJqPQAC_RsAAiGfQVadbFGzD8OUSDYE"], ["id" => "Puck", "name" => "پویا (مرد)", "sticker_id" => "CAACAgUAAxkBAAEYPU1ox-Tn17qfYDuN9_VzcaWxHMxhFwACIRgAAno_QFZ5ZPKwGVwlWzYE"], ["id" => "Kore", "name" => "مهتاب (زن)", "sticker_id" => "CAACAgUAAxkBAAEYPU9ox-UhdAH61qvl4urbSsE5w56TtAACfBgAApy0QFYZ0Az3CdbMZzYE"], ["id" => "Fenrir", "name" => "سام (مرد)", "sticker_id" => "CAACAgUAAxkBAAEYPVFox-UtHi1p9mAMzteL26LhKAaBBgACVB0AArXbQFbW8BK3mtfIezYE"], ["id" => "Leda", "name" => "لیدا (زن)", "sticker_id" => "CAACAgUAAxkBAAEYPVNox-U-8jIxsxjNdcBNURwMFq9--wACtBkAAqelOVaJlegbhzaYWjYE"]
];
$speaker_count = count($speakers);
$mainMenu = [
    'keyboard' => [
        [['text' => 'تبدیل متن به صدا 🎙️']],
        [['text' => '🌡️ تنظیم خلاقیت'], ['text' => '💳 خرید اشتراک']],
        [['text' => '👥 دعوت از دوستان'], ['text' => '👤 حساب من']],
        [['text' => '📞 پشتیبانی'], ['text' => 'راهنما ℹ️']]
    ],
    'resize_keyboard' => true
];

if ($_SERVER['REQUEST_METHOD'] === 'HEAD') { http_response_code(200); exit(); }
if (isset($_GET['Authority']) && isset($_GET['Status'])) { handleZarinpalCallback(); exit(); }
$update_json = file_get_contents('php://input');
if (empty($update_json)) {
    http_response_code(200);
    echo "Alpha TTS Bot is alive on Render.com.";
    exit();
}
http_response_code(200);
if (function_exists('fastcgi_finish_request')) { fastcgi_finish_request(); }
$update = json_decode($update_json, true);
if (isset($update['callback_query'])) {
    handleCallbackQuery($update['callback_query']);
} elseif (isset($update['message'])) {
    handleMessage($update['message']);
}
exit();

function handleMessage($message) {
    global $mainMenu, $speakers, $speaker_count;
    $chat_id = $message['from']['id'];
    $user_data = loadUserData($chat_id);
    if ($user_data === null) { return; }
    $lock_timeout = 540;
    if (isset($user_data['processing_lock']) && (time() - $user_data['processing_lock']) < $lock_timeout) {
        exit();
    }
    $user_data['processing_lock'] = time();
    saveUserData($chat_id, $user_data);
    register_shutdown_function('release_lock', $chat_id);
    $user_state = $user_data['state'] ?? 'normal';
    if (isset($message['sticker'])) {
        $sticker_file_id = $message['sticker']['file_id'];
        foreach ($speakers as $speaker) {
            if ($speaker['sticker_id'] === $sticker_file_id) {
                $user_data['speaker'] = $speaker['id'];
                if ($user_state === 'awaiting_speaker_selection') { unset($user_data['state']); }
                saveUserData($chat_id, $user_data);
                $confirmation_text = "✅ گوینده شما با موفقیت به **" . $speaker['name'] . "** تغییر کرد.\n\nاکنون می‌توانید متن خود را برای تبدیل به صدا با صدای ایشان ارسال کنید.";
                sendMessage($chat_id, $confirmation_text);
                return;
            }
        }
        return;
    }
    $text = $message['text'] ?? '';
    $processed_text = convertPersianNumbersToEnglish($text);
    if (strpos($processed_text, '/start') === 0) {
        $parts = explode(' ', $processed_text);
        if (count($parts) > 1 && strpos($parts[1], 'ref_') === 0) {
            $inviter_id = substr($parts[1], 4);
            $new_user_data = loadUserData($chat_id);
            if (count($new_user_data) <= 2 && $inviter_id != $chat_id) { // <=2 because lock is set
                $inviter_data = loadUserData($inviter_id);
                $inviter_credits = $inviter_data['free_credits_remaining'] ?? 10;
                $inviter_data['free_credits_remaining'] = $inviter_credits + 8;
                saveUserData($inviter_id, $inviter_data);
                sendMessage($inviter_id, "🎉 تبریک! یک کاربر جدید از طریق لینک شما به ربات پیوست. **۸ اعتبار رایگان** به شما هدیه داده شد.");
            }
        }
        sendMessage($chat_id, "سلام! به ربات تبدیل متن به صدای آلفا خوش آمدید.", json_encode($mainMenu));
        return;
    }
    switch($text) {
        case 'تبدیل متن به صدا 🎙️': case '/speakers': startSpeakerSelection($chat_id); return;
        case '🌡️ تنظیم خلاقیت': showTemperatureMenu($chat_id); return;
        case '💳 خرید اشتراک': showSubscriptionMenu($chat_id); return;
        case '👥 دعوت از دوستان': showReferralInfo($chat_id); return;
        case '👤 حساب من': showAccountStatus($chat_id); return;
        case '📞 پشتیبانی': showSupportMenu($chat_id); return;
        case 'راهنما ℹ️': showHelp($chat_id); return;
        case '/cancel':
            if ($user_state === 'awaiting_speaker_selection') {
                unset($user_data['state']);
                saveUserData($chat_id, $user_data);
                sendMessage($chat_id, "انتخاب گوینده لغو شد.");
            }
            return;
    }
    if ($user_state === 'awaiting_speaker_selection') {
        if (is_numeric($processed_text) && $processed_text >= 1 && $processed_text <= $speaker_count) {
            $selected_index = intval($processed_text) - 1;
            $selected_speaker = $speakers[$selected_index];
            $user_data['speaker'] = $selected_speaker['id'];
            unset($user_data['state']);
            saveUserData($chat_id, $user_data);
            $confirmation_text = "✅ گوینده شما با موفقیت به **" . $selected_speaker['name'] . "** تغییر کرد.\n\nاکنون می‌توانید متن خود را برای تبدیل به صدا با صدای ایشان ارسال کنید.";
            sendSticker($chat_id, $selected_speaker['sticker_id']);
            sendMessage($chat_id, $confirmation_text);
        } else {
            sendMessage($chat_id, "❗️خطا: لطفا یک عدد معتبر (فارسی یا انگلیسی) بین 1 تا {$speaker_count} ارسال کنید.");
        }
        return;
    }
    if (empty(trim($text))) { return; }
    if (!canUserConvert($chat_id)) {
        sendMessage($chat_id, "❌ اعتبار رایگان شما به پایان رسیده است.\n\nبرای استفاده نامحدود، لطفا از دکمه '💳 خرید اشتراک' یک پلن تهیه کنید.");
        return;
    }
    $wait_message_json = telegramApiRequest('sendMessage', ['chat_id' => $chat_id, 'text' => "⏳ لطفاً صبر کنید..."]);
    $wait_message_id = json_decode($wait_message_json, true)['result']['message_id'];
    $prompt = '';
    $clean_text = $text;
    if (preg_match('/ \((.*?)\)\s*$/u', $text, $matches)) {
        $prompt = $matches[1];
        $clean_text = preg_replace('/ \((.*?)\)\s*$/u', '', $text);
    }
    $text_chunks = splitTextIntoChunks($clean_text);
    $audio_files = [];
    $has_error = false;
    foreach ($text_chunks as $index => $chunk) {
        editMessageText($chat_id, $wait_message_id, "⏳ در حال پردازش بخش " . ($index + 1) . " از " . count($text_chunks) . " ...");
        $current_user_data = loadUserData($chat_id);
        $speaker_id = $current_user_data['speaker'] ?? 'Charon';
        $temperature = $current_user_data['temperature'] ?? 0.9;
        $requestData = [ 'text' => $chunk, 'prompt' => $prompt, 'speaker' => $speaker_id, 'temperature' => $temperature, 'subscriptionStatus' => 'paid', 'fingerprint' => 'php-telegram-bot-v1'];
        $headers = ['Content-Type: application/json', 'x-internal-api-key: ' . INTERNAL_API_SECRET];
        $ch = curl_init(RENDER_API_URL);
        curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_POST => true, CURLOPT_POSTFIELDS => json_encode($requestData), CURLOPT_HTTPHEADER => $headers, CURLOPT_TIMEOUT => 120]);
        $audio_data = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($http_code == 200 && !empty($audio_data)) {
            $temp_file = tempnam(sys_get_temp_dir(), 'tts') . '.wav';
            file_put_contents($temp_file, $audio_data);
            $audio_files[] = $temp_file;
        } else {
            $has_error = true;
            break;
        }
    }
    deleteMessage($chat_id, $wait_message_id);
    if ($has_error || empty($audio_files)) {
        sendMessage($chat_id, "متاسفانه مشکلی در تولید صدا پیش آمد.");
        return;
    }
    $final_audio_path = mergeWavFiles($audio_files);
    if ($final_audio_path) {
        $current_user_data = loadUserData($chat_id);
        $speaker_id = $current_user_data['speaker'] ?? 'Charon';
        $selected_speaker_sticker = '';
        foreach ($speakers as $speaker) { if ($speaker['id'] === $speaker_id) { $selected_speaker_sticker = $speaker['sticker_id']; break; } }
        if ($selected_speaker_sticker) { sendSticker($chat_id, $selected_speaker_sticker); }
        sendAudio($chat_id, file_get_contents($final_audio_path), '🔊 صدای شما تولید شد.');
        @unlink($final_audio_path);
    } else {
        sendMessage($chat_id, "خطا در ادغام فایل‌های صوتی.");
    }
    foreach($audio_files as $file) {
        @unlink($file);
    }
}
function release_lock($chat_id) {
    $user_data = loadUserData($chat_id);
    if ($user_data !== null) {
        unset($user_data['processing_lock']);
        saveUserData($chat_id, $user_data);
    }
}
function handleCallbackQuery($callback_query) {
    $chat_id = $callback_query['message']['chat']['id'];
    $message_id = $callback_query['message']['message_id'];
    $data = $callback_query['data'];
    list($action, $value) = explode('_', $data, 2);
    if ($action === 'settemp') {
        $user_data = loadUserData($chat_id);
        if ($user_data === null) { answerCallbackQuery($callback_query['id'], "خطا در دسترسی به اطلاعات.", true); return; }
        $user_data['temperature'] = floatval($value);
        saveUserData($chat_id, $user_data);
        $level_text = ['0.3' => 'کم', '0.7' => 'متوسط', '0.9' => 'پیش‌فرض', '1.2' => 'زیاد'];
        $selected_level = $level_text[$value] ?? $value;
        answerCallbackQuery($callback_query['id'], "خلاقیت روی '" . $selected_level . "' تنظیم شد.");
        editMessageText($chat_id, $message_id, "✅ خلاقیت صدا با موفقیت روی **" . $selected_level . "** (" . $value . ") تنظیم شد.");
    }
    if ($action === 'subscribe') {
        $plan_id = $value;
        $plan = SUBSCRIPTION_PLANS[$plan_id];
        $price_in_rial = $plan['price'] * 10;
        $description = "خرید اشتراک " . $plan['name'];
        $params = ['merchant_id' => ZARINPAL_MERCHANT_ID, 'amount' => $price_in_rial, 'description' => $description, 'callback_url' => CALLBACK_URL, 'metadata' => ['chat_id' => $chat_id, 'plan_id' => $plan_id]];
        $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/request.json');
        curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_POST => true, CURLOPT_POSTFIELDS => json_encode($params), CURLOPT_HTTPHEADER => ['Content-Type: application/json']]);
        $result_json = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result_json, true);
        if (isset($result['data']['code']) && $result['data']['code'] == 100) {
            $authority = $result['data']['authority'];
            $payment_url = 'https://www.zarinpal.com/pg/StartPay/' . $authority;
            savePaymentData($authority, ['chat_id' => $chat_id, 'plan_id' => $plan_id, 'amount' => $price_in_rial]);
            $keyboard = ['inline_keyboard' => [[['text' => '✅ پرداخت آنلاین', 'url' => $payment_url]]]];
            editMessageText($chat_id, $message_id, "برای تکمیل خرید اشتراک **" . $plan['name'] . "** لطفا روی دکمه زیر کلیک کنید:", json_encode($keyboard));
        } else {
            editMessageText($chat_id, $message_id, "❌ خطا در اتصال به درگاه پرداخت. لطفا لحظاتی بعد دوباره تلاش کنید.");
        }
        answerCallbackQuery($callback_query['id']);
    }
}
function handleZarinpalCallback() {
    $authority = $_GET['Authority'];
    $status = $_GET['Status'];
    $payment_data = loadPaymentData($authority);
    if ($payment_data === null) { echo "تراکنش یافت نشد یا منقضی شده است."; return; }
    $chat_id = $payment_data['chat_id'];
    $plan_id = $payment_data['plan_id'];
    $amount = $payment_data['amount'];
    if ($status == 'OK') {
        $params = ['merchant_id' => ZARINPAL_MERCHANT_ID, 'amount' => $amount, 'authority' => $authority];
        $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/verify.json');
        curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_POST => true, CURLOPT_POSTFIELDS => json_encode($params), CURLOPT_HTTPHEADER => ['Content-Type: application/json']]);
        $result_json = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result_json, true);
        if (isset($result['data']['code']) && ($result['data']['code'] == 100 || $result['data']['code'] == 101)) {
            $plan = SUBSCRIPTION_PLANS[$plan_id];
            $user_data = loadUserData($chat_id);
            if ($user_data === null) { echo "خطا در پردازش اطلاعات حساب."; return; }
            $current_expiry = $user_data['subscription_expiry'] ?? time();
            $start_date = ($current_expiry > time()) ? $current_expiry : time();
            $new_expiry = strtotime($plan['duration'], $start_date);
            $user_data['subscription_expiry'] = $new_expiry;
            saveUserData($chat_id, $user_data);
            sendMessage($chat_id, "✅ پرداخت شما با موفقیت تایید شد.\n\nاشتراک شما تا تاریخ **" . date("Y-m-d H:i", $new_expiry) . "** فعال گردید.");
            echo "پرداخت موفق. می‌توانید به ربات برگردید.";
        } else {
            sendMessage($chat_id, "❌ مشکلی در تایید تراکنش شما پیش آمد. کد خطا: " . ($result['errors']['code'] ?? 'Unknown'));
            echo "تایید تراکنش ناموفق بود.";
        }
    } else {
        sendMessage($chat_id, "❌ شما تراکنش را لغو کردید.");
        echo "تراکنش لغو شد.";
    }
    deletePaymentData($authority);
}
function apiRequest($payload) {
    $ch = curl_init(USER_API_URL);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'X-Api-Secret: ' . USER_API_SECRET
        ],
        CURLOPT_TIMEOUT => 10
    ]);
    $response_json = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($http_code == 200 && $response_json) {
        $response = json_decode($response_json, true);
        if ($response && $response['status'] === 'success') {
            return $response['data'] ?? true;
        }
    }
    return null;
}
function loadUserData($chat_id) { return apiRequest(['action' => 'load_user', 'chat_id' => $chat_id]); }
function saveUserData($chat_id, $data) { apiRequest(['action' => 'save_user', 'chat_id' => $chat_id, 'data' => $data]); }
function loadPaymentData($authority) { return apiRequest(['action' => 'load_payment', 'authority' => $authority]); }
function savePaymentData($authority, $data) { apiRequest(['action' => 'save_payment', 'authority' => $authority, 'data' => $data]); }
function deletePaymentData($authority) { apiRequest(['action' => 'delete_payment', 'authority' => $authority]); }
function canUserConvert($chat_id) {
    $user_data = loadUserData($chat_id);
    if ($user_data === null) return false;
    if (isset($user_data['subscription_expiry']) && $user_data['subscription_expiry'] > time()) { return true; }
    $credits = $user_data['free_credits_remaining'] ?? 10;
    if ($credits > 0) {
        $user_data['free_credits_remaining'] = $credits - 1;
        saveUserData($chat_id, $user_data);
        return true;
    }
    return false;
}
function telegramApiRequest($method, $parameters = []) {
    $url = "https://api.telegram.org/bot" . TELEGRAM_BOT_TOKEN . "/" . $method;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}
function showSubscriptionMenu($chat_id) {
    $keyboard = ['inline_keyboard' => []];
    foreach (SUBSCRIPTION_PLANS as $id => $plan) {
        $button_text = $plan['name'] . " - " . number_format($plan['price']) . " تومان";
        $keyboard['inline_keyboard'][] = [['text' => $button_text, 'callback_data' => 'subscribe_' . $id]];
    }
    sendMessage($chat_id, "لطفا یکی از پلن‌های اشتراک زیر را انتخاب کنید:", json_encode($keyboard));
}
function showAccountStatus($chat_id) {
    $user_data = loadUserData($chat_id);
    if ($user_data === null) { sendMessage($chat_id, "خطا در دریافت اطلاعات حساب."); return; }
    $status_text = "📊 وضعیت حساب شما:\n\n";
    if (isset($user_data['subscription_expiry']) && $user_data['subscription_expiry'] > time()) {
        $status_text .= "🌟 **نوع حساب:** نامحدود\n";
        $status_text .= "🗓 **تاریخ انقضا:** " . date("Y-m-d H:i", $user_data['subscription_expiry']);
    } else {
        $credits = $user_data['free_credits_remaining'] ?? 10;
        $status_text .= "▫️ **نوع حساب:** رایگان\n";
        $status_text .= "🎙 **اعتبار باقی‌مانده:** " . $credits . " عدد";
    }
    sendMessage($chat_id, $status_text);
}
function startSpeakerSelection($chat_id) {
    $user_data = loadUserData($chat_id);
    if ($user_data === null) { sendMessage($chat_id, "خطا در دسترسی به حساب."); return; }
    $user_data['state'] = 'awaiting_speaker_selection';
    saveUserData($chat_id, $user_data);
    $media_group = [];
    $caption_text = "گالری گویندگان\n\nلطفا **شماره** گوینده مورد نظر خود را از روی عکس‌ها ارسال کنید.";
    foreach (SPEAKER_PAGES as $index => $url) {
        $media_item = ['type' => 'photo', 'media' => $url];
        if ($index === 0) { $media_item['caption'] = $caption_text; $media_item['parse_mode'] = 'Markdown'; }
        $media_group[] = $media_item;
    }
    telegramApiRequest('sendMediaGroup', ['chat_id' => $chat_id, 'media' => json_encode($media_group)]);
    sendMessage($chat_id, "برای لغو انتخاب، دستور /cancel را ارسال کنید.");
}
function showSupportMenu($chat_id) {
    $supportKeyboard = ['inline_keyboard' => [[['text' => '💬 ارتباط با پشتیبانی', 'url' => 'https://t.me/' . SUPPORT_USERNAME]]]];
    sendMessage($chat_id, "برای ارتباط با پشتیبانی روی دکمه زیر کلیک کنید:", json_encode($supportKeyboard));
}
function showHelp($chat_id) {
    $help_text = "راهنمای استفاده از ربات آلفا:\n\n";
    $help_text .= "1️⃣ **تبدیل ساده متن:**\nکافیست متن خود را ارسال کنید.\n\n";
    $help_text .= "2️⃣ **افزودن لحن و احساس:**\nتوصیف لحن را در انتهای متن خود و داخل پرانتز `()` قرار دهید.\n*مثال:* `سلام (با لحنی خوشحال)`\n\n";
    $help_text .= "3️⃣ **تغییر گوینده:**\nاز منو، گزینه 'تبدیل متن به صدا 🎙️' را انتخاب کنید.\n\n";
    $help_text .= "4️⃣ **تنظیم خلاقیت:**\nاز منو، گزینه '🌡️ تنظیم خلاقیت' را انتخاب کنید.\n\n";
    $help_text .= "5️⃣ **دعوت از دوستان:**\nاز منو، گزینه '👥 دعوت از دوستان' را انتخاب کرده و با لینک اختصاصی خود، برای هر عضویت جدید ۸ اعتبار رایگان هدیه بگیرید.";
    sendMessage($chat_id, $help_text);
}

function showReferralInfo($chat_id) {
    $referral_link = 'https://t.me/' . BOT_USERNAME . '?start=ref_' . $chat_id;
    $banner_image_url = 'https://uploadkon.ir/uploads/501e16_251758015004030.jpg';

    // متن کپشن برای بنر
    $caption = "💎 قویترین هوش مصنوعی تبدیل متن به صدای فارسی\n\n";
    $caption .= "🎤 متن دلخواهت رو وارد کن فایل صوتی با صدای شخصیت های مختلف زن و مرد تحویل بگیر\n\n";
    $caption .= "🗣 تبدیل متن با بیش از 25 گوینده و پشتیبانی از همه زبان ها\n\n";
    // تغییر در این خط: بک‌تیک‌ها حذف شدند تا لینک قابل کلیک باشد
    $caption .= "🎁 ربات رو استارت کن و لذت ببر 👇\n\n" . $referral_link;

    // ارسال بنر (تصویر + کپشن)
    sendPhoto($chat_id, $banner_image_url, $caption);

    // ارسال پیام متنی جداگانه بعد از بنر
    $follow_up_message = "برای دریافت 💳 اعتبار رایگان بنر بالا را به اشتراک بگزارید. برای هر نفر که با لینک شما وارد ربات شود 8 تبدیل رایگان هدیه 🎁 دریافت میکنید.";
    sendMessage($chat_id, $follow_up_message);
}

function sendPhoto($chat_id, $photo_url, $caption = null, $reply_markup = null) {
    $params = ['chat_id' => $chat_id, 'photo' => $photo_url];
    if ($caption) {
        $params['caption'] = $caption;
        // parse_mode را حذف میکنیم تا تلگرام خودش لینک را شناسایی کند و نیازی به فرمت Markdown نباشد
        // $params['parse_mode'] = 'Markdown'; 
    }
    if ($reply_markup) {
        $params['reply_markup'] = $reply_markup;
    }
    telegramApiRequest('sendPhoto', $params);
}

function showTemperatureMenu($chat_id) {
    $tempKeyboard = ['inline_keyboard' => [[['text' => 'کم (پایدار)', 'callback_data' => 'settemp_0.3'], ['text' => 'متوسط', 'callback_data' => 'settemp_0.7']], [['text' => 'پیش‌فرض (بهینه)', 'callback_data' => 'settemp_0.9'], ['text' => 'زیاد (احساسی)', 'callback_data' => 'settemp_1.2']]]];
    sendMessage($chat_id, "لطفا میزان خلاقیت و پویایی صدا را انتخاب کنید:", json_encode($tempKeyboard));
}
function sendMessage($chat_id, $message, $reply_markup = null) {
    $params = ['chat_id' => $chat_id, 'text' => $message, 'parse_mode' => 'Markdown'];
    if ($reply_markup) { $params['reply_markup'] = $reply_markup; }
    telegramApiRequest('sendMessage', $params);
}
function editMessageText($chat_id, $message_id, $text, $reply_markup = null) {
    $params = ['chat_id' => $chat_id, 'message_id' => $message_id, 'text' => $text, 'parse_mode' => 'Markdown'];
    if ($reply_markup) { $params['reply_markup'] = $reply_markup; }
    telegramApiRequest('editMessageText', $params);
}
function deleteMessage($chat_id, $message_id) {
    telegramApiRequest('deleteMessage', ['chat_id' => $chat_id, 'message_id' => $message_id]);
}
function answerCallbackQuery($callback_query_id, $text = '', $show_alert = false) {
    telegramApiRequest('answerCallbackQuery', ['callback_query_id' => $callback_query_id, 'text' => $text, 'show_alert' => $show_alert]);
}
function sendSticker($chat_id, $file_id) {
    if (!$file_id || strpos($file_id, 'PLACEHOLDER') !== false) return;
    telegramApiRequest('sendSticker', ['chat_id' => $chat_id, 'sticker' => $file_id]);
}
function sendAudio($chat_id, $audio_data, $caption = '') {
    $temp_file_path = sys_get_temp_dir() . '/' . uniqid('tts_audio_', true) . '.wav';
    file_put_contents($temp_file_path, $audio_data);
    telegramApiRequest('sendAudio', ['chat_id' => $chat_id, 'audio' => new CURLFile($temp_file_path, 'audio/wav', 'voice.wav'), 'caption' => $caption]);
    @unlink($temp_file_path);
}
function convertPersianNumbersToEnglish($string) {
    $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    return str_replace($persian, $english, $string);
}
function splitTextIntoChunks($text, $maxLength = 2500) {
    $chunks = [];
    $text = trim($text);
    if (mb_strlen($text, 'UTF-8') <= $maxLength) { return [$text]; }
    while (mb_strlen($text, 'UTF-8') > 0) {
        if (mb_strlen($text, 'UTF-8') <= $maxLength) { $chunks[] = $text; break; }
        $chunk_candidate = mb_substr($text, 0, $maxLength, 'UTF-8');
        $split_pos = -1;
        $delimiters = ["\n", ".", "!", "؟", "،", " "];
        foreach ($delimiters as $delimiter) {
            $last_pos = mb_strrpos($chunk_candidate, $delimiter, 0, 'UTF-8');
            if ($last_pos !== false) { $split_pos = $last_pos + mb_strlen($delimiter, 'UTF-8'); break; }
        }
        if ($split_pos === -1) { $split_pos = $maxLength; }
        $chunks[] = trim(mb_substr($text, 0, $split_pos, 'UTF-8'));
        $text = trim(mb_substr($text, $split_pos, null, 'UTF-8'));
    }
    return array_filter($chunks, function($chunk) { return !empty($chunk); });
}
function mergeWavFiles($files) {
    if (empty($files)) return null;
    if (count($files) == 1) return $files[0];
    $first_file_content = @file_get_contents($files[0]);
    if(!$first_file_content) return null;
    $header = substr($first_file_content, 0, 44);
    $all_data = substr($first_file_content, 44);
    for ($i = 1; $i < count($files); $i++) {
        $content = @file_get_contents($files[$i]);
        if ($content) { $all_data .= substr($content, 44); }
    }
    $data_size = strlen($all_data);
    $file_size = $data_size + 36;
    $header = substr_replace($header, pack('V', $file_size), 4, 4);
    $header = substr_replace($header, pack('V', $data_size), 40, 4);
    $final_file_path = tempnam(sys_get_temp_dir(), 'tts_merged') . '.wav';
    file_put_contents($final_file_path, $header . $all_data);
    return $final_file_path;
}
?>
