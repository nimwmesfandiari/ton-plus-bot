const express = require("express");
const fetch = require("node-fetch");
const app = express();

app.use(express.json());

const TOKEN = "8047223304:AAHMW8a6tKTTSQOp4Os_LorRJzDLNvxz-Rw";
const API = `https://api.telegram.org/bot${TOKEN}`;

app.post("/mine", async (req,res)=>{
  const { userId, balance } = req.body;

  await fetch(`${API}/sendMessage`,{
    method:"POST",
    headers:{ "Content-Type":"application/json" },
    body:JSON.stringify({
      chat_id: userId,
      text: `⛏ Mining\nBalance: ${balance.toFixed(6)} TON`
    })
  });

  res.json({ok:true});
});

app.listen(3000,()=>console.log("Bot server running"));
