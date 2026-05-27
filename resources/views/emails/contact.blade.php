<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
    body {
        font-family: Arial, sans-serif;
        background: #f5f5f5;
        margin: 0;
        padding: 20px;
    }

    .card {
        background: #fff;
        border-radius: 12px;
        padding: 30px;
        max-width: 500px;
        margin: auto;
        border: 1px solid #e2eae3;
    }

    h2 {
        color: #1F3A2C;
        font-size: 1.2rem;
        margin-bottom: 20px;
    }

    .label {
        font-size: 0.75rem;
        color: #7A8A7C;
        margin-bottom: 2px;
    }

    .value {
        font-size: 0.9rem;
        color: #1F3A2C;
        margin-bottom: 16px;
        font-weight: 600;
    }

    .pesan {
        background: #f5f4f0;
        border-radius: 8px;
        padding: 12px;
        font-size: 0.88rem;
        color: #4A5E4C;
        line-height: 1.6;
    }

    .footer {
        margin-top: 24px;
        font-size: 0.72rem;
        color: #aaa;
        text-align: center;
    }
    </style>
</head>

<body>
    <div class="card">
        <h2>📬 Pesan Masuk — KosinAja!</h2>
        <div class="label">Nama</div>
        <div class="value">{{ $data['nama'] }}</div>
        <div class="label">Email</div>
        <div class="value">{{ $data['email'] }}</div>
        <div class="label">Topik</div>
        <div class="value">{{ $data['topik'] }}</div>
        <div class="label">Pesan</div>
        <div class="pesan">{{ $data['pesan'] }}</div>
        <div class="footer">Dikirim melalui form KosinAja! &mdash; kosinaja.com</div>
    </div>
</body>

</html>