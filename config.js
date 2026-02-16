// این فایل اطلاعات حساس رو از متغیرهای محیطی می‌گیره
export default function handler(req, res) {
  // فقط به دامنه خودتون اجازه بدید
  const origin = req.headers.origin;
  const allowedOrigins = [
    'https://tondropy.vercel.app',  // دامنه خودتون
    'http://localhost:3000'          // برای تست محلی
  ];
  
  // تنظیم CORS headers
  res.setHeader('Access-Control-Allow-Origin', origin || '*');
  res.setHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
  
  if (req.method === 'OPTIONS') {
    return res.status(200).end();
  }

  // برگردوندن تنظیمات از متغیرهای محیطی
  res.status(200).json({
    botToken: process.env.BOT_TOKEN,
    adminId: process.env.ADMIN_ID,
    adminUsername: process.env.ADMIN_USERNAME,
    walletAddress: process.env.WALLET_ADDRESS,
    secretCodes: JSON.parse(process.env.SECRET_CODES || '[]')
  });
}
