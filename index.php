<?php
// ===================================================================
// ALPHA BOT - RENDER.COM
// Version: 5.0 - Added Speech-to-Text via Hugging Face Space
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
// آدرس سرویس تبدیل صوت به متن شما در Hugging Face
define('HF_SPACE_API_URL', 'https://ezmary-sadabematn.hf.space');


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

// کیبورد اصلی با دکمه جدید
$mainMenu = [
    'keyboard' => [
        [['text' => 'تبدیل متن به صدا 🎙️'], ['text' => 'تبدیل فایل صوتی به متن 🎧']],
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
    echo "Alpha Bot is alive on Render.com.";
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

    // مدیریت فایل صوتی برای تبدیل به متن
    if ($user_state === 'awaiting_audio' && (isset($message['audio']) || isset($message['voice']))) {
        handleAudioFile($chat_id, $message);
        return;
    }

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
            if (count($new_user_data) <= 2 && $inviter_id != $chat_id) { 
                $inviter_data = loadUserData($inviter_id);
                $inviter_credits = $inviter_data['free_credits_remaining'] ?? 10;
                $inviter_data['free_credits_remaining'] = $inviter_credits + 8;
                saveUserData($inviter_id, $inviter_data);
                sendMessage($inviter_id, "🎉 تبریک! یک کاربر جدید از طریق لینک شما به ربات پیوست. **۸ اعتبار رایگان** به شما هدیه داده شد.");
            }
        }
        sendMessage($chat_id, "سلام! به ربات آلفا خوش آمدید.", json_encode($mainMenu));
        return;
    }
    switch($text) {
        case 'تبدیل متن به صدا 🎙️': case '/speakers': startSpeakerSelection($chat_id); return;
        case 'تبدیل فایل صوتی به متن 🎧': startAudioTranscription($chat_id); return;
        case '🌡️ تنظیم خلاقیت': showTemperatureMenu($chat_id); return;
        case '💳 خرید اشتراک': showSubscriptionMenu($chat_id); return;
        case '👥 دعوت از دوستان': showReferralInfo($chat_id); return;
        case '👤 حساب من': showAccountStatus($chat_id); return;
        case '📞 پشتیبانی': showSupportMenu($chat_id); return;
        case 'راهنما ℹ️': showHelp($chat_id); return;
        case '/cancel':
            if ($user_state === 'awaiting_speaker_selection' || $user_state === 'awaiting_audio') {
                unset($user_data['state']);
                saveUserData($chat_id, $user_data);
                sendMessage($chat_id, "عملیات لغو شد.");
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
        sendMessage($chat_id, "❌ اعتبار رایگان شما برای تبدیل متن به صدا به پایان رسیده است.\n\nبرای استفاده نامحدود، لطفا از دکمه '💳 خرید اشتراک' یک پلن تهیه کنید.");
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
    // ... محتوای این تابع بدون تغییر باقی می‌ماند ...
}
function handleZarinpalCallback() {
    // ... محتوای این تابع بدون تغییر باقی می‌ماند ...
}
function apiRequest($payload) {
    // ... محتوای این تابع بدون تغییر باقی می‌ماند ...
}
// توابع مدیریت دیتا بدون تغییر
function loadUserData($chat_id) { return apiRequest(['action' => 'load_user', 'chat_id' => $chat_id]); }
function saveUserData($chat_id, $data) { apiRequest(['action' => 'save_user', 'chat_id' => $chat_id, 'data' => $data]); }
function loadPaymentData($authority) { return apiRequest(['action' => 'load_payment', 'authority' => $authority]); }
function savePaymentData($authority, $data) { apiRequest(['action' => 'save_payment', 'authority' => $authority, 'data' => $data]); }
function deletePaymentData($authority) { apiRequest(['action' => 'delete_payment', 'authority' => $authority]); }
function canUserConvert($chat_id) {
    // ... محتوای این تابع بدون تغییر باقی می‌ماند ...
}
function telegramApiRequest($method, $parameters = []) {
    // ... محتوای این تابع بدون تغییر باقی می‌ماند ...
}
// توابع نمایش منو ها
function showSubscriptionMenu($chat_id) {
    // ... محتوای این تابع بدون تغییر باقی می‌ماند ...
}
function showAccountStatus($chat_id) {
    // ... محتوای این تابع بدون تغییر باقی می‌ماند ...
}
function startSpeakerSelection($chat_id) {
    // ... محتوای این تابع بدون تغییر باقی می‌ماند ...
}
function showSupportMenu($chat_id) {
    // ... محتوای این تابع بدون تغییر باقی می‌ماند ...
}
function showHelp($chat_id) {
    // ... محتوای این تابع بدون تغییر باقی می‌ماند ...
}
function showReferralInfo($chat_id) {
    // ... محتوای این تابع بدون تغییر باقی می‌ماند ...
}
function showTemperatureMenu($chat_id) {
    // ... محتوای این تابع بدون تغییر باقی می‌ماند ...
}
// توابع ارسال پیام
function sendMessage($chat_id, $message, $reply_markup = null) {
    // ... محتوای این تابع بدون تغییر باقی می‌ماند ...
}
function editMessageText($chat_id, $message_id, $text, $reply_markup = null) {
    // ... محتوای این تابع بدون تغییر باقی می‌ماند ...
}
function deleteMessage($chat_id, $message_id) {
    // ... محتوای این تابع بدون تغییر باقی می‌ماند ...
}
function answerCallbackQuery($callback_query_id, $text = '', $show_alert = false) {
    // ... محتوای این تابع بدون تغییر باقی می‌ماند ...
}
function sendSticker($chat_id, $file_id) {
    // ... محتوای این تابع بدون تغییر باقی می‌ماند ...
}
function sendAudio($chat_id, $audio_data, $caption = '') {
    // ... محتوای این تابع بدون تغییر باقی می‌ماند ...
}
// توابع کمکی
function convertPersianNumbersToEnglish($string) {
    // ... محتوای این تابع بدون تغییر باقی می‌ماند ...
}
function splitTextIntoChunks($text, $maxLength = 2500) {
    // ... محتوای این تابع بدون تغییر باقی می‌ماند ...
}
function mergeWavFiles($files) {
    // ... محتوای این تابع بدون تغییر باقی می‌ماند ...
}


// ===================================================================
// START: توابع جدید برای تبدیل صوت به متن
// ===================================================================

/**
 * کاربر را برای ارسال فایل صوتی آماده می‌کند.
 */
function startAudioTranscription($chat_id) {
    $user_data = loadUserData($chat_id);
    if ($user_data === null) { sendMessage($chat_id, "خطا در دسترسی به حساب."); return; }
    
    $user_data['state'] = 'awaiting_audio';
    saveUserData($chat_id, $user_data);
    
    sendMessage($chat_id, "🎧 لطفاً فایل صوتی، ویس یا ویدیوی خود را برای تبدیل به متن ارسال کنید.\n\nبرای لغو /cancel را بفرستید.");
}

/**
 * فایل صوتی دریافت شده از کاربر را پردازش می‌کند.
 */
function handleAudioFile($chat_id, $message) {
    $user_data = loadUserData($chat_id);
    // بازنشانی وضعیت کاربر
    unset($user_data['state']);
    saveUserData($chat_id, $user_data);

    $file_id = null;
    $mime_type = null;
    if (isset($message['voice'])) {
        $file_id = $message['voice']['file_id'];
        $mime_type = $message['voice']['mime_type'];
    } elseif (isset($message['audio'])) {
        $file_id = $message['audio']['file_id'];
        $mime_type = $message['audio']['mime_type'];
    }

    if ($file_id === null) {
        sendMessage($chat_id, "فایل صوتی معتبری یافت نشد.");
        return;
    }
    
    $wait_message_json = telegramApiRequest('sendMessage', ['chat_id' => $chat_id, 'text' => "⏳ فایل شما دریافت شد. لطفاً برای پردازش منتظر بمانید..."]);
    $wait_message_id = json_decode($wait_message_json, true)['result']['message_id'];

    // 1. دریافت مسیر فایل از تلگرام
    $file_info_json = telegramApiRequest('getFile', ['file_id' => $file_id]);
    $file_info = json_decode($file_info_json, true);
    if (!$file_info['ok']) {
        deleteMessage($chat_id, $wait_message_id);
        sendMessage($chat_id, "خطا در دریافت اطلاعات فایل از تلگرام.");
        return;
    }
    $file_path = $file_info['result']['file_path'];
    $file_url = 'https://api.telegram.org/file/bot' . TELEGRAM_BOT_TOKEN . '/' . $file_path;

    // 2. دانلود فایل صوتی
    $audio_data = @file_get_contents($file_url);
    if ($audio_data === false) {
        deleteMessage($chat_id, $wait_message_id);
        sendMessage($chat_id, "خطا در دانلود فایل صوتی از سرور تلگرام.");
        return;
    }
    
    // ذخیره فایل در یک مکان موقت
    $temp_file_path = tempnam(sys_get_temp_dir(), 'tg_audio_') . '.' . pathinfo($file_path, PATHINFO_EXTENSION);
    file_put_contents($temp_file_path, $audio_data);
    
    // 3. ارسال فایل به Hugging Face Space
    $ch = curl_init(HF_SPACE_API_URL . '/api/transcribe');
    $cFile = new CURLFile($temp_file_path, $mime_type, basename($temp_file_path));
    $post_data = ['audio_file' => $cFile];
    
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $post_data,
        CURLOPT_TIMEOUT => 60
    ]);
    
    $response_json = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    @unlink($temp_file_path); // حذف فایل موقت

    if ($http_code != 202) {
        deleteMessage($chat_id, $wait_message_id);
        sendMessage($chat_id, "خطا در ارتباط با سرویس پردازش صدا. لطفا بعدا تلاش کنید.\nکد خطا: " . $http_code);
        return;
    }
    
    $response = json_decode($response_json, true);
    $task_id = $response['task_id'] ?? null;
    
    if (!$task_id) {
        deleteMessage($chat_id, $wait_message_id);
        sendMessage($chat_id, "سرویس پردازش صدا پاسخ معتبری نداد.");
        return;
    }
    
    // 4. بررسی وضعیت تسک تا زمان تکمیل
    $result_text = null;
    $max_retries = 40; // حدود 2 دقیقه (40 * 3 ثانیه)
    for ($i = 0; $i < $max_retries; $i++) {
        sleep(3);
        $status_ch = curl_init(HF_SPACE_API_URL . '/api/podcast-status/' . $task_id);
        curl_setopt_array($status_ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 10]);
        $status_json = curl_exec($status_ch);
        curl_close($status_ch);
        
        $status_data = json_decode($status_json, true);
        
        if ($status_data['status'] === 'completed') {
            $result_text = $status_data['data']['transcription'] ?? 'متنی یافت نشد.';
            break;
        } elseif ($status_data['status'] === 'failed') {
            $error_message = $status_data['error'] ?? 'خطای نامشخص در پردازش';
            $result_text = "❌ **خطا در پردازش فایل:**\n" . $error_message;
            break;
        }
        // اگر pending بود، به حلقه ادامه می‌دهد
    }
    
    deleteMessage($chat_id, $wait_message_id);

    if ($result_text === null) {
        sendMessage($chat_id, "پردازش فایل شما بیش از حد طول کشید. لطفا فایل‌های کوتاه‌تر را امتحان کنید یا بعداً دوباره تلاش کنید.");
    } else {
        sendMessage($chat_id, "📄 **متن استخراج شده از فایل صوتی شما:**\n\n" . $result_text);
    }
}

// ===================================================================
// END: توابع جدید برای تبدیل صوت به متن
// ===================================================================

?>
