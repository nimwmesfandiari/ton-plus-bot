const express = require("express");
const fetch = require("node-fetch");

const app = express();
app.use(express.json());

/* ========= BOT TOKEN (فقط اینجا، امن) ========= */
const BOT_TOKEN = process.env.BOT_TOKEN || "PUT_YOUR_BOT_TOKEN_HERE";
const TG_API = `https://api.telegram.org/bot${BOT_TOKEN}`;

/* ========= WEBAPP (HTML) ========= */
const html = `
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TON Miner</title>
<script src="https://telegram.org/js/telegram-web-app.js"></script>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:tahoma}
body{background:#0f1525;color:#fff;height:100vh;overflow:hidden}
header{height:60px;background:#121a2f;display:flex;align-items:center;justify-content:space-between;padding:0 16px}
main{height:calc(100vh - 120px);position:relative}
.page{display:none;height:100%;padding:20px}
.page.active{display:block}
.balance{text-align:center;margin-top:30px}
.balance h1{font-size:36px;color:#00cfff}
.mine-btn{
width:200px;height:200px;border-radius:50%;
margin:30px auto;
background:radial-gradient(circle,#00cfff,#006a9c);
display:flex;align-items:center;justify-content:center;
font-size:24px;font-weight:bold;
box-shadow:0 0 40px rgba(0,200,255,.6)
}
nav{height:60px;background:#121a2f;display:flex}
nav button{flex:1;background:none;border:none;color:#aaa}
nav button.active{color:#00cfff}
.card{background:#18213b;border-radius:16px;padding:16px}
</style>
</head>

<body>
<header>
  <div>🟢 Online</div>
  <div id="username">Guest</div>
</header>

<main>
  <div class="page active" id="home">
    <div class="balance">
      <p>Balance</p>
      <h1 id="balance">0.000000</h1>
      <small>TON</small>
    </div>
    <div class="mine-btn" id="mineBtn">MINE</div>
  </div>

  <div class="page" id="wallet">
    <div class="card">
      <h3>Wallet</h3>
      <p id="walletBalance">0.000000 TON</p>
    </div>
  </div>
</main>

<nav>
  <button class="active" data-page="home">Home</button>
  <button data-page="wallet">Wallet</button>
</nav>

<script>
const tg = window.Telegram?.WebApp;
let userId = "guest";

if(tg){
  tg.ready(); tg.expand();
  if(tg.initDataUnsafe?.user){
    userId = tg.initDataUnsafe.user.id;
    document.getElementById("username").innerText = tg.initDataUnsafe.user.first_name;
  }
}

let balance = Number(localStorage.getItem("bal_"+userId)) || 0;
const balanceEl = document.getElementById("balance");
const walletEl = document.getElementById("walletBalance");

function render(){
  balanceEl.innerText = balance.toFixed(6);
  walletEl.innerText = balance.toFixed(6)+" TON";
}
render();

function mine(){
  balance += 0.0001;
  localStorage.setItem("bal_"+userId,balance);
  render();

  fetch("/mine",{
    method:"POST",
    headers:{ "Content-Type":"application/json" },
    body:JSON.stringify({ userId, balance })
  });
}

document.getElementById("mineBtn").onclick = mine;
document.getElementById("mineBtn").ontouchstart = mine;

document.querySelectorAll("nav button").forEach(btn=>{
  btn.onclick=()=>{
    document.querySelectorAll(".page").forEach(p=>p.classList.remove("active"));
    document.querySelectorAll("nav button").forEach(b=>b.classList.remove("active"));
    document.getElementById(btn.dataset.page).classList.add("active");
    btn.classList.add("active");
  }
});
</script>
</body>
</html>
`;

/* ========= ROUTES ========= */
app.get("/", (req,res)=>res.send(html));

app.post("/mine", async (req,res)=>{
  const { userId, balance } = req.body;
  if(!userId) return res.json({ok:false});

  await fetch(\`\${TG_API}/sendMessage\`,{
    method:"POST",
    headers:{ "Content-Type":"application/json" },
    body:JSON.stringify({
      chat_id:userId,
      text:\`⛏ Mining\\nBalance: \${balance.toFixed(6)} TON\`
    })
  });

  res.json({ok:true});
});

/* ========= START ========= */
const PORT = process.env.PORT || 3000;
app.listen(PORT, ()=>console.log("Server running on",PORT));
