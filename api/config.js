// فایل api/config.js باید دقیقاً این باشد:
export default function handler(req, res) {
  res.setHeader('Access-Control-Allow-Origin', '*');
  res.status(200).json({
    botToken: process.env.BOT_TOKEN || "8047223304:AAHMW8a6tKTTSQOp4Os_LorRJzDLNvxz-Rw",
    adminId: process.env.ADMIN_ID || "5972276401",
    adminUsername: process.env.ADMIN_USERNAME || "miningertoncoin",
    walletAddress: process.env.WALLET_ADDRESS || "UQDFlvMPZoQy4zySI8gLLMteRcxHRB28IHW0JuwFVk10u0Y",
    secretCodes: ["T61O96N12", "VipTonDropy"]
  });
}
