<?php
require 'config.php';
$no_header = false;
session_start();
?>

<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>بوابة الخدمات الحكومية الإلكترونية</title>

  <!-- خط عربي -->
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Cairo',sans-serif; }
    :root { --bg:#f7fafc; --muted:#6c757d; --accent:#0A7075; --card-bg:#ffffff; --card-border:rgba(10,112,117,0.08); --shadow:0 10px 30px rgba(10,112,117,0.10);}
    body { background: var(--bg); color: #0b1220; }

    .hero { min-height: calc(100vh - 86px); display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; margin-top:75px; padding:0 20px; }
    .hero h2 { font-size:56px; font-weight:800; color:#0A7075; margin-bottom:20px; line-height:1.2; }
    .hero h2 .line2 { display:block; font-size:60px; color:#063f42; margin-top:5px; }
    .hero p { font-size:20px; max-width:700px; margin:0 auto 30px; color:#444; line-height:1.6; }
    .hero-cta { display:flex; gap:15px; justify-content:center; flex-wrap:wrap; }

    .btn-primary, .btn-outline { display:inline-block; padding:12px 30px; border-radius:30px; font-size:1.1rem; text-decoration:none; transition:0.3s; }
    .btn-primary { background:#0A7075; color:#fff; border:none; }
    .btn-primary:hover { background:#095d62; }
    .btn-outline { border:2px solid #0A7075; color:#0A7075; }
    .btn-outline:hover { background:#0A7075; color:white; }

    .section { padding:80px 20px; max-width:1200px; margin:0 auto; text-align:center; }
    .section-header h3 { font-size:36px; font-weight:900; color:#0A7075; margin-bottom:10px; }
    .section-header p { color:var(--muted); font-size:16px; }

    /* --- Grid Services --- */
    .services-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 35px;
      margin-top: 60px;
    }

    @media (max-width: 992px) {
      .services-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 600px) {
      .services-grid { grid-template-columns: 1fr; }
    }

    .service-card {
      background:white; border-radius:18px; padding:25px; text-align:center;
      border:1px solid rgba(10,112,117,0.08); box-shadow:0 5px 15px rgba(10,112,117,0.08);
      transition: all 0.3s ease;
    }
    .service-card:hover { transform: translateY(-8px); box-shadow:0 20px 40px rgba(10,112,117,0.15); border-color:#0A7075; }

    .service-card .icon {
      width:70px; height:70px; border-radius:50%;
      background:linear-gradient(180deg, rgba(10,112,117,0.15), rgba(10,112,117,0.05));
      color:#0A7075; font-size:28px; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;
    }

    .service-card h4 { margin:10px 0 12px; font-size:20px; font-weight:700; color:#0A7075; }
    .service-card p { color:#555; font-size:14px; line-height:1.7; }

    .why-choose-us { background:#eef3f3; text-align:center; padding:100px 20px; }
    .why-choose-us h2 { font-size:2.4rem; color:#0A7075; font-weight:800; margin-bottom:60px; }

    .features-container { display:grid; grid-template-columns:repeat(3,1fr); gap:40px; max-width:1100px; margin:0 auto; }
    .feature-box { background:white; border-radius:20px; padding:40px 20px; box-shadow:0 4px 12px rgba(0,0,0,0.08); transition:0.3s; }
    .feature-box:hover { transform:translateY(-5px); }
    .feature-icon { background-color:#0A7075; color:white; font-size:28px; width:70px; height:70px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px; }

    .cta-section { text-align:center; padding:80px 20px; }
    .cta-section h2 { color:#0A7075; font-size:2rem; font-weight:800; margin-bottom:20px; }
    .cta-section p { color:#555; font-size:1.1rem; margin-bottom:30px; }
    
  </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<main>
  <section class="hero">
    <h2>بوابة الخدمات <span class="line2">الحكومية الإلكترونية</span></h2>
    <p>احصل على جميع الوثائق والخدمات الحكومية بسهولة وسرعة من خلال منصتنا الإلكترونية المتكاملة</p>
    <div class="hero-cta">
      <a href="./register_citizen.php" class="btn-primary">ابدأ الآن</a>
      <a href="about.php" class="btn-outline">تعرف علينا</a>
    </div>
  </section>

  <section id="services" class="section">
    <div class="section-header">
      <h3>خدماتنا</h3>
      <p>نوفر لك مجموعة شاملة من الخدمات الحكومية الإلكترونية</p>
    </div>

    <div class="services-grid">
      <div class="service-card">
        <div class="icon"><i class="fa-solid fa-file-lines"></i></div>
        <h4>وثيقة ولادة</h4>
        <a href="javascript:void(0)" onclick="openModal('بدِّك تقدّمي طلب وثيقة ولادة؟', 'وثيقة ولادة')" class="btn-primary" style="padding:8px 15px; font-size:14px;">إلي</a>
        
      </div>

      <div class="service-card">
        <div class="icon"><i class="fa-solid fa-id-card"></i></div>
        <h4>بطاقة الهوية</h4>
        <a href="javascript:void(0)" onclick="openModal('بدِّك تقدّمي طلب بطاقة هوية؟', 'بطاقة الهوية')" class="btn-primary" style="padding:8px 15px; font-size:14px;">إلي</a>
        <a href="./child_form.php" class="btn-outline" style="padding:8px 15px; font-size:14px;">لولادي</a>
      </div>

      <div class="service-card">
        <div class="icon"><i class="fa-solid fa-users"></i></div>
        <h4>إخراج قيد عائلي</h4>
        <a href="javascript:void(0)" onclick="openModal('بدِّك تقدّمي إخراج قيد عائلي؟', 'إخراج قيد عائلي')" class="btn-primary" style="padding:8px 15px; font-size:14px;">إلي</a>
        
      </div>

      <div class="service-card">
        <div class="icon"><i class="fa-solid fa-user"></i></div>
        <h4>إخراج قيد فردي</h4>
        <a href="javascript:void(0)" onclick="openModal('بدِّك تقدّمي إخراج قيد فردي؟', 'إخراج قيد فردي')" class="btn-primary" style="padding:8px 15px; font-size:14px;">إلي</a>
        
      </div>

      <div class="service-card">
        <div class="icon"><i class="fa-solid fa-ring"></i></div>
        <h4>وثيقة زواج</h4>
        <a href="javascript:void(0)" onclick="openModal('بدِّك تقدّمي وثيقة زواج؟', 'وثيقة زواج')" class="btn-primary" style="padding:8px 15px; font-size:14px;">إلي</a>
        
      </div>

      <div class="service-card">
        <div class="icon"><i class="fa-solid fa-file-circle-xmark"></i></div>
        <h4>وثيقة وفاة</h4>
        <a href="javascript:void(0)" onclick="openModal('بدِّك تقدّمي وثيقة وفاة؟', 'وثيقة وفاة')" class="btn-primary" style="padding:8px 15px; font-size:14px;">إلي</a>
        
      </div>
    </div>
  </section>

  <section class="why-choose-us">
    <h2>لماذا تختارنا؟</h2>
    <div class="features-container">
      <div class="feature-box">
        <div class="feature-icon"><i class="fa-solid fa-bolt"></i></div>
        <h3>سرعة في الإنجاز</h3>
        <p>احصل على خدماتك في أسرع وقت ممكن دون أي تأخير.</p>
      </div>
      <div class="feature-box">
        <div class="feature-icon"><i class="fa-solid fa-shield-halved"></i></div>
        <h3>أمان وخصوصية</h3>
        <p>بياناتك محمية بأعلى معايير الأمان والسرية.</p>
      </div>
      <div class="feature-box">
        <div class="feature-icon"><i class="fa-solid fa-thumbs-up"></i></div>
        <h3>سهولة الاستخدام</h3>
        <p>واجهة بسيطة وسهلة الاستخدام لجميع المستخدمين.</p>
      </div>
    </div>
  </section>

  <section class="cta-section">
    <h2>ابدأ باستخدام خدماتنا الآن</h2>
    <p>سجل حساباً جديداً وابدأ بالحصول على جميع الخدمات الحكومية بكل سهولة.</p>
    <a href="./register_citizen.php" class="btn-primary">إنشاء حساب جديد</a>
  </section>
</main>

<!-- Modal -->
<div id="confirmModal" style="position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); display:none; align-items:center; justify-content:center; z-index:9999;">
  <div style="background:white; padding:25px; border-radius:12px; width:320px; text-align:center;">
    <h3 style="margin-bottom:15px;">تأكيد الطلب</h3>
    <p id="modalMessage" style="margin-bottom:20px; font-size:15px;">هل تريد تقديم طلب؟</p>
    <button id="confirmYes" style="padding:10px 20px; background:#0A7075; color:white; border:none; border-radius:8px; cursor:pointer; margin-right:10px;">نعم</button>
    <button onclick="closeModal()" style="padding:10px 20px; background:#ccc; border:none; border-radius:8px; cursor:pointer;">لا</button>
  </div>
</div>

<script>
let targetTransactionType = "";

function openModal(message, transactionType) {
    document.getElementById("modalMessage").textContent = message;
    targetTransactionType = transactionType;
    document.getElementById("confirmModal").style.display = "flex";
}

function closeModal() {
    document.getElementById("confirmModal").style.display = "none";
}

document.getElementById("confirmYes").onclick = function () {
    fetch('add_request.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ transactionType: targetTransactionType })
    })
    .then(response => response.json())
   .then(data => {
    if(data.success){
        closeModal();
        alert("تم تسجيل الطلب بنجاح!");
        if(typeof updateDashboardCounts === "function"){
            updateDashboardCounts();
        }
    } else {
        // عرض رسالة السيرفر الفعلية
        alert("حدث خطأ: " + (data.message || "حاول مرة أخرى"));
    }
})

};
</script>


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>معاملات Chat</title>
<style>
#chatToggle {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #0A7075;
    color: white;
    width: 55px;
    height: 55px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 26px;
    cursor: pointer;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
    z-index: 9999;
}
#chatBox {
    position: fixed;
    bottom: 90px;
    right: 20px;
    width: 300px;
    height: 380px;
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
    display: none;
    flex-direction: column;
    z-index: 9999;
}
#chatBox .header {
    background: #0A7075;
    color: white;
    padding: 10px;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
    font-weight: bold;
    text-align: center;
}
#messages {
    flex: 1;
    padding: 10px;
    overflow-y: auto;
}
#userInput {
    padding: 10px;
    border: none;
    border-top: 1px solid #eee;
    width: 100%;
    outline: none;
}
.message-bot {
    background: #f0f0f0;
    padding: 5px 8px;
    border-radius: 8px;
    margin: 5px 0;
}
.message-user {
    background: #0A7075;
    color: white;
    padding: 5px 8px;
    border-radius: 8px;
    margin: 5px 0;
    text-align: right;
}

.typing {
    font-style: italic;
    color: #666;
    background: #f1f1f1;
    padding: 6px 10px;
    border-radius: 8px;
    margin: 5px 0;
    width: fit-content;
}

</style>
</head>
<body>

<div id="chatToggle" onclick="toggleChat()">💬</div>

<div id="chatBox">
    <div class="header">AI Chat</div>
    <div id="messages"></div>
    <input id="userInput" type="text" placeholder="اكتبي رسالتك..." onkeypress="if(event.key==='Enter') sendMessage()">
    
</div>

<script>
function toggleChat(){
    let chat = document.getElementById("chatBox");
    chat.style.display = (chat.style.display === "flex") ? "none" : "flex";
}

async function sendMessage(){
    let input = document.getElementById("userInput");
    let text = input.value;
    if(text.trim() === "") return;

    let msgBox = document.getElementById("messages");
    msgBox.innerHTML += "<div class='message-user'><b>أنت:</b> " + text + "</div>";
    input.value = "";
    msgBox.scrollTop = msgBox.scrollHeight;

    try {
        let res = await fetch("chatbot.controller.php?action=chat", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ message: text })
        });

        let data = await res.json();
        let botReply = "عذراً، لم أستطع الرد الآن.";

        if(data.status && data.data && data.data.botResponse){
            botReply = data.data.botResponse;
        } else if(data.error){
            botReply = data.error;
        }

        msgBox.innerHTML += "<div class='message-bot'><b>Bot:</b> " + botReply + "</div>";
        msgBox.scrollTop = msgBox.scrollHeight;
    } catch(err) {
        msgBox.innerHTML += "<div class='message-bot'><b>Bot:</b> حدث خطأ، حاول لاحقاً.</div>";
        msgBox.scrollTop = msgBox.scrollHeight;
    }
}
</script>
<?php include 'footer.php'; ?>




</body>
</html>
