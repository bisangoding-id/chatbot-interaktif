Repository ini menyediakan endpoint webhook untuk menangani berbagai event dari WhatsApp Cloud API, termasuk pesan masuk, status pesan (sent, delivered, read), media (gambar, audio, video, dokumen), serta interaksi pengguna seperti tombol dan daftar pilihan.
Webhook ini memungkinkan Anda membangun berbagai solusi otomatisasi, seperti:
- Chatbot & Auto-reply: Menangani pertanyaan pelanggan secara otomatis.
- Customer Service Automation: Mempermudah agen fokus pada kasus yang kompleks.
- Pengiriman Notifikasi: Memberikan update real-time terkait transaksi, pengiriman, atau alert sistem.
- Integrasi Sistem: Menghubungkan WhatsApp dengan CRM, ticketing, ERP, atau platform internal lainnya.

Dirancang modular dan aman, webhook ini menggunakan VERIFY_TOKEN untuk memastikan request berasal dari WhatsApp Cloud API, serta struktur handler yang mudah dikembangkan agar setiap event dapat diproses sesuai kebutuhan aplikasi Anda.

## Fungsi
- Menerima dan memproses pesan masuk WhatsApp (text, image, audio, video, document, sticker).
- Menangani status pesan (sent, delivered, read, failed).
- Mendukung pesan interactive (button reply, list reply).
- Struktur handler modular untuk setiap tipe event.
- Validasi webhook menggunakan VERIFY_TOKEN.
- Logging event untuk debugging dan analisis.
  
## Cara Kerja
- Pengguna mengirim pesan ke nomor WhatsApp Business Anda.
- Meta Graph API mengirim HTTP POST ke server Anda.
- Server menerima payload dan melakukan verifikasi.
- Sistem membaca jenis event dan memprosesnya
- Server dapat membalas pesan menggunakan endpoint Send Message WhatsApp Cloud API.

## Tutorial Lengkap

Panduan lengkap pembuatan WhatsApp Bot ini dapat dilihat di:

- **YouTube Playlist:**  
  https://www.youtube.com/playlist?list=PL0xxlUJSOUAoGCfkJazP94D1PbB9NQl5-
  
- **Website :**  
  https://www.bisangoding.id
