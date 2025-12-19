<?php
require_once "auth_middleware.php";

// ====== إعدادات Gemini ======
$GEMINI_API_KEY = "AIzaSyAU1gpUw9R681NfawO2xZhNJbi72afKcj8";
$GEMINI_MODEL = "gemini-2.0-flash";

// ====== النصوص الأساسية ======
$APP_CONTEXT = "
أنت مساعد ذكي متخصص بالإجابة عن معاملات دائرة النفوس في لبنان.
يجب أن تكون إجاباتك واضحة وبجملة قصيرة وسهلة الفهم.

تشمل المعلومات التي تجيب عنها:
- كيفية إصدار بطاقة الهوية
- كيفية الحصول على إخراج قيد فردي أو عائلي
- كيفية إصدار بيان ولادة
- كيفية إصدار بيان وفاة
- المستندات المطلوبة لكل معاملة
- مدة التنفيذ
- أماكن تقديم الطلبات
- الرسوم والطوابع
- خطوات تقديم الطلب
";

$ADMIN_DASHBOARD_CONTEXT = "
أنت مساعد ذكي للوحة التحكم في تطبيق بلدي.
تشرح كيفية إدارة المتاجر، الطلبات، المحتوى، والإحصائيات.
";

// ====== الاتصال بـ Gemini ======
function callGeminiAPI($prompt) {
    global $GEMINI_API_KEY, $GEMINI_MODEL;

    $url = "https://generativelanguage.googleapis.com/v1beta/models/$GEMINI_MODEL:generateContent?key=$GEMINI_API_KEY";

    $payload = [
        "contents" => [
            ["parts" => [["text" => $prompt]]]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);

    if(curl_errno($ch)){
        $err = curl_error($ch);
        curl_close($ch);
        return ["error" => "Curl Error: $err"];
    }

    curl_close($ch);
    return json_decode($response, true);
}

// ====== CHAT FOR USER ======
function chatWithGemini() {
    global $APP_CONTEXT;

    $data = json_decode(file_get_contents("php://input"), true);
    $message = trim($data["message"] ?? "");

    if ($message === "") {
        echo json_encode(["error" => "Message is required"]);
        return;
    }

    // ====== Trigger ذكي لمعرفة قصد المستخدم ======
    if (preg_match("/هوية|اخراج|قيد|ولادة|وفاة|بطاقة|معاملة|دائرة النفوس/i", $message)) {
        $message = "أريد معلومات عن معاملات دائرة النفوس: $message";
    }

    $prompt = $APP_CONTEXT . "\n\nسؤال المستخدم:\n$message\n\nالرد:";

    $result = callGeminiAPI($prompt);

    if(isset($result["error"])){
        echo json_encode(["error" => $result["error"]]);
        return;
    }

    $botResponse = $result["candidates"][0]["content"]["parts"][0]["text"]
        ?? "عذراً، لم أستطع توليد رد مناسب.";

    echo json_encode([
        "status" => true,
        "data" => [
            "userMessage" => $message,
            "botResponse" => $botResponse
        ]
    ]);
}

// ====== CHAT FOR ADMIN ======
function chatWithGeminiDash() {
    global $ADMIN_DASHBOARD_CONTEXT;

    $data = json_decode(file_get_contents("php://input"), true);
    $message = trim($data["message"] ?? "");

    if ($message === "") {
        echo json_encode(["error" => "Message is required"]);
        return;
    }

    $prompt = $ADMIN_DASHBOARD_CONTEXT . "\n\nسؤال:\n$message\n\nالرد:";

    $result = callGeminiAPI($prompt);

    // معالجة الأخطاء
    if(isset($result["error"])) {
        echo json_encode([
            "status"=>false,
            "error"=>"API Error: ".$result["error"]
        ]);
        return;
    }

    $botResponse = $result["candidates"][0]["content"]["parts"][0]["text"]
        ?? "Error: Missing response from Gemini.";

    echo json_encode([
        "status"=>true,
        "data"=>[
            "userMessage"=>$message,
            "botResponse"=>$botResponse,
            "timestamp"=>date("c")
        ]
    ]);
}

// ====== SUGGESTIONS ======
function getChatSuggestions() {
    echo json_encode([
        "status" => true,
        "data" => [
            "كيف أعمل بطاقة هوية؟",
            "كيف أعمل إخراج قيد فردي؟",
            "ما هي المستندات المطلوبة للولادة؟",
            "كم يستغرق إصدار هوية؟",
            "أين أقدم طلب إخراج قيد؟"
        ]
    ]);
}

// ====== ROUTER ======
$action = $_GET['action'] ?? '';

switch($action){
    case 'chat':
        session_start();
        chatWithGemini();
        break;

    case 'chatDash':
        session_start();
        chatWithGeminiDash();
        break;

    case 'suggestions':
        session_start();
        getChatSuggestions();
        break;

    default:
        echo json_encode(["error" => "Action not found"]);
}
?>
