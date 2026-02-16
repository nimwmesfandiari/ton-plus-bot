// این فایل باید دقیقاً همین باشه
export default function handler(req, res) {
  // تنظیم CORS برای دسترسی از هر جایی
  res.setHeader('Access-Control-Allow-Origin', '*');
  res.setHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
  
  if (req.method === 'OPTIONS') {
    return res.status(200).end();
  }

  // برگردوندن تنظیمات
  res.status(200).json({
    botToken: process.env.BOT_TOKEN,
    adminId: process.env.ADMIN_ID,
    adminUsername: process.env.ADMIN_USERNAME,
    walletAddress: process.env.WALLET_ADDRESS,
    secretCodes: process.env.SECRET_CODES ? JSON.parse(process.env.SECRET_CODES) : []
  });
}
