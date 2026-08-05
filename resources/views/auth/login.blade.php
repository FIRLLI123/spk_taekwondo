<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Login SPK Pemilihan Atlet Terbaik Taekwondo - Metode TOPSIS">

    <title>Login | SPK Atlet Taekwondo | Lathifah Ayudya Maharani</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root{
            --blue-700:#1a4fb0;
            --blue-600:#2f6fe0;
            --blue-500:#4f8bff;
            --blue-400:#7dabff;
            --blue-300:#a9c7ff;
            --sky-100:#eaf2ff;
            --ice-50:#f5f9ff;
            --gold-400:#f2b84b;
            --gold-300:#ffd479;
            --white:#ffffff;
            --ink:#0c1a33;
            --muted:#6b7a99;
        }

        *{ box-sizing:border-box; }

        body{
            margin:0;
            min-height:100vh;
            font-family:'Inter', sans-serif;
            background:linear-gradient(135deg, #eaf2ff 0%, #dbe8ff 45%, #cfe0ff 100%);
            display:flex;
            align-items:center;
            justify-content:center;
            padding:24px;
            overflow-x:hidden;
        }

        .auth-shell{
            width:100%;
            max-width:1000px;
            min-height:600px;
            display:grid;
            grid-template-columns:1.05fr 1fr;
            background:var(--white);
            border-radius:24px;
            overflow:hidden;
            box-shadow:0 30px 70px rgba(47,111,224,.25);
            opacity:0;
            transform:translateY(24px) scale(.97);
            animation:shellIn .75s cubic-bezier(.34,1.4,.4,1) forwards;
        }

        @keyframes shellIn{
            to{ opacity:1; transform:translateY(0) scale(1); }
        }

        /* ---------- Left panel ---------- */
        .panel-brand{
            position:relative;
            background:
                radial-gradient(120% 140% at 10% 0%, rgba(255,255,255,.25) 0%, transparent 50%),
                linear-gradient(160deg, var(--blue-500) 0%, var(--blue-700) 100%);
            color:var(--white);
            padding:52px 44px;
            display:flex;
            flex-direction:column;
            justify-content:space-between;
            overflow:hidden;
        }

        .panel-brand::before{
            content:"";
            position:absolute;
            inset:-40% -20% auto auto;
            width:420px; height:420px;
            background:conic-gradient(from 0deg, rgba(255,255,255,.35), transparent 30%, transparent 70%, rgba(255,255,255,.25));
            opacity:.5;
            border-radius:50%;
            animation:spin 22s linear infinite;
        }

        @keyframes spin{ to{ transform:rotate(360deg); } }

        /* floating sparkles - lucu bits */
        .sparkle{
            position:absolute;
            z-index:2;
            color:var(--gold-300);
            opacity:.9;
            animation:float 3.4s ease-in-out infinite;
        }
        .sparkle.s1{ top:18%; right:14%; font-size:16px; animation-delay:0s; }
        .sparkle.s2{ top:52%; right:6%; font-size:11px; animation-delay:.7s; color:#fff; }
        .sparkle.s3{ top:12%; right:32%; font-size:9px; animation-delay:1.4s; color:#fff; }
        .sparkle.s4{ bottom:14%; right:22%; font-size:13px; animation-delay:.35s; }

        @keyframes float{
            0%,100%{ transform:translateY(0) rotate(0deg) scale(1); opacity:.9; }
            50%{ transform:translateY(-10px) rotate(18deg) scale(1.15); opacity:1; }
        }

        /* kicking mascot - lucu */
        .mascot{
            position:absolute;
            z-index:2;
            top:26px;
            right:34px;
            width:46px; height:46px;
            border-radius:50%;
            background:rgba(255,255,255,.16);
            border:1.5px solid rgba(255,255,255,.4);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:19px;
            color:var(--white);
            animation:kick 1.8s ease-in-out infinite;
        }

        @keyframes kick{
            0%, 100%{ transform:rotate(0deg) translateY(0); }
            20%{ transform:rotate(-18deg) translateY(-2px); }
            40%{ transform:rotate(22deg) translateY(-4px); }
            60%{ transform:rotate(-8deg) translateY(0); }
            80%{ transform:rotate(6deg) translateY(-1px); }
        }

        .brand-top{ position:relative; z-index:2; display:flex; align-items:center; gap:12px; }

        .brand-mark{
            width:42px; height:42px; border-radius:12px;
            background:linear-gradient(135deg, var(--blue-500), var(--blue-700));
            display:flex; align-items:center; justify-content:center;
            font-size:19px;
            box-shadow:0 8px 20px rgba(47,111,224,.45);
        }

        .brand-name{ font-family:'Poppins',sans-serif; font-weight:700; font-size:15px; letter-spacing:.3px; }
        .brand-name span{ display:block; font-family:'Inter',sans-serif; font-weight:400; font-size:11px; color:rgba(255,255,255,.75); letter-spacing:.5px; }

        .brand-mid{ position:relative; z-index:2; margin:36px 0; }

        .brand-mid h1{
            font-family:'Poppins',sans-serif;
            font-weight:800;
            font-size:30px;
            line-height:1.25;
            margin:0 0 14px;
        }
        .brand-mid h1 em{ font-style:normal; color:var(--gold-400); }

        .brand-mid p{
            margin:0;
            font-size:14px;
            line-height:1.7;
            color:#c3d3f2;
            max-width:340px;
        }

        /* Ranking visual - the signature element */
        .rank-board{
            position:relative;
            z-index:2;
            display:flex;
            align-items:flex-end;
            gap:16px;
            margin-top:38px;
            height:130px;
        }

        .rank-col{
            flex:1;
            position:relative;
            display:flex;
            flex-direction:column;
            align-items:center;
            gap:8px;
        }

        .rank-bar{
            width:100%;
            position:relative;
            border-radius:8px 8px 4px 4px;
            background:linear-gradient(180deg, #fff, var(--blue-300));
            transform:scaleY(0);
            transform-origin:bottom;
            animation:riseUp .8s cubic-bezier(.34,1.6,.4,1) forwards;
        }

        .rank-col.gold .rank-bar{
            background:linear-gradient(180deg, var(--gold-300), var(--gold-400));
            animation:riseUp .8s cubic-bezier(.34,1.6,.4,1) forwards, bounceWin 1.6s ease-in-out .9s infinite;
        }

        .rank-col:nth-child(1) .rank-bar{ height:78px; animation-delay:.5s; }
        .rank-col:nth-child(2) .rank-bar{ height:118px; animation-delay:.35s; }
        .rank-col:nth-child(3) .rank-bar{ height:56px; animation-delay:.65s; }

        @keyframes riseUp{ to{ transform:scaleY(1); } }
        @keyframes bounceWin{
            0%,100%{ transform:scaleY(1) translateY(0); }
            50%{ transform:scaleY(1) translateY(-6px); }
        }

        .rank-col.gold::before{
            content:"\f091";
            font-family:"Font Awesome 6 Free";
            font-weight:900;
            position:absolute;
            top:-26px;
            font-size:14px;
            color:var(--gold-400);
            animation:trophyPop 1.6s ease-in-out .9s infinite;
        }

        @keyframes trophyPop{
            0%,100%{ transform:translateY(0) rotate(0deg); }
            50%{ transform:translateY(-9px) rotate(-8deg); }
        }

        .rank-label{ font-size:11px; color:rgba(255,255,255,.75); font-weight:500; }
        .rank-score{ font-family:'Poppins',sans-serif; font-size:12px; font-weight:700; color:var(--white); }

        .brand-foot{
            position:relative; z-index:2;
            display:flex; gap:22px;
            font-size:11px; color:#8fa4cf;
            border-top:1px solid rgba(255,255,255,.08);
            padding-top:18px;
        }
        .brand-foot i{ color:var(--gold-400); margin-right:5px; }

        /* ---------- Right panel ---------- */
        .panel-form{
            padding:56px 48px;
            display:flex;
            flex-direction:column;
            justify-content:center;
        }

        .form-head{ margin-bottom:30px; }
        .form-head h2{
            font-family:'Poppins',sans-serif;
            font-weight:700;
            font-size:24px;
            color:var(--ink);
            margin:0 0 6px;
        }
        .form-head p{ margin:0; font-size:13.5px; color:var(--muted); }

        .alert-box{
            display:flex; align-items:center; gap:10px;
            background:#fdeeee; color:#a3312f;
            border:1px solid #f3c9c8;
            border-radius:10px;
            padding:11px 14px;
            font-size:13px;
            margin-bottom:20px;
            animation:shake .45s ease;
        }
        @keyframes shake{
            0%,100%{ transform:translateX(0); }
            25%{ transform:translateX(-4px); }
            75%{ transform:translateX(4px); }
        }

        .field{ margin-bottom:18px; }
        .field label{
            display:block;
            font-size:12.5px;
            font-weight:600;
            color:var(--ink);
            margin-bottom:7px;
        }

        .field-input{
            position:relative;
            display:flex;
            align-items:center;
        }

        .field-input i{
            position:absolute;
            left:15px;
            color:var(--muted);
            font-size:14px;
            transition:color .2s;
        }

        .field-input input{
            width:100%;
            height:48px;
            border:1.5px solid #e3e8f2;
            background:var(--ice-50);
            border-radius:12px;
            padding:0 44px;
            font-size:14px;
            font-family:'Inter',sans-serif;
            color:var(--ink);
            outline:none;
            transition:border-color .2s, box-shadow .2s, background .2s;
        }

        .field-input input::placeholder{ color:#a7b2c6; }

        .field-input input:focus{
            border-color:var(--blue-500);
            background:var(--white);
            box-shadow:0 0 0 4px rgba(47,111,224,.14);
        }

        .field-input input:focus + i,
        .field-input:has(input:focus) i{ color:var(--blue-500); }

        .toggle-pass{
            position:absolute;
            right:15px;
            left:auto;
            cursor:pointer;
            background:none;
            border:none;
            padding:0;
        }

        .row-between{
            display:flex;
            align-items:center;
            justify-content:space-between;
            margin:4px 0 24px;
            font-size:13px;
        }

        .remember{ display:flex; align-items:center; gap:8px; color:var(--muted); }
        .remember input{ accent-color:var(--blue-500); width:15px; height:15px; }

        .btn-login{
            width:100%;
            height:50px;
            border:none;
            border-radius:12px;
            background:linear-gradient(135deg, var(--blue-500), var(--blue-700));
            color:var(--white);
            font-family:'Poppins',sans-serif;
            font-weight:600;
            font-size:15px;
            letter-spacing:.2px;
            cursor:pointer;
            display:flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            box-shadow:0 12px 24px rgba(26,79,176,.32);
            transition:transform .15s ease, box-shadow .15s ease, filter .15s ease;
        }

        .btn-login:hover{
            transform:translateY(-2px);
            box-shadow:0 16px 28px rgba(26,79,176,.4);
            filter:brightness(1.06);
        }
        .btn-login:active{ transform:translateY(0); }

        .form-foot{
            text-align:center;
            margin-top:26px;
            font-size:12px;
            color:var(--muted);
        }
        .form-foot strong{ color:var(--ink); }

        @media (max-width: 820px){
            .auth-shell{ grid-template-columns:1fr; max-width:440px; }
            .panel-brand{ display:none; }
            .panel-form{ padding:44px 30px; }
        }

        @media (prefers-reduced-motion: reduce){
            *{ animation:none !important; transition:none !important; }
        }
    </style>
</head>
<body>

    <div class="auth-shell">

        <div class="panel-brand">
            <div class="mascot"><i class="fa-solid fa-person-running"></i></div>
            <i class="fa-solid fa-star sparkle s1"></i>
            <i class="fa-solid fa-star sparkle s2"></i>
            <i class="fa-solid fa-star sparkle s3"></i>
            <i class="fa-solid fa-bolt sparkle s4"></i>

            <div class="brand-top">
                <img src="{{ asset('logo-topsis.png') }}" alt="Logo TOPSIS" style="width: 42px; height: 42px; object-fit: contain; border-radius: 8px; background: rgba(255, 255, 255, 0.9); padding: 4px; box-shadow: 0 8px 20px rgba(0,0,0,0.15);">
                <div class="brand-name">SPK Atlet Taekwondo <br> Lathifah Ayudya Maharani<span>Sistem Pendukung Keputusan</span></div>
            </div>

            <div class="brand-mid">
                <h1>Pilih atlet terbaik<br>dengan <em>data</em>, bukan tebakan.</h1>
                <p>Sistem penunjang keputusan untuk menentukan atlet taekwondo terbaik menggunakan metode TOPSIS &mdash; objektif, terukur, dan transparan.</p>

                <div class="rank-board">
                    <div class="rank-col">
                        <span class="rank-score">0.82</span>
                        <div class="rank-bar"></div>
                        <span class="rank-label">Rank 2</span>
                    </div>
                    <div class="rank-col gold">
                        <span class="rank-score">0.94</span>
                        <div class="rank-bar"></div>
                        <span class="rank-label">Rank 1</span>
                    </div>
                    <div class="rank-col">
                        <span class="rank-score">0.71</span>
                        <div class="rank-bar"></div>
                        <span class="rank-label">Rank 3</span>
                    </div>
                </div>
            </div>

            <div class="brand-foot">
                <span><i class="fa-solid fa-chart-line"></i>Metode TOPSIS</span>
                <span><i class="fa-solid fa-shield-halved"></i>Penilaian objektif</span>
            </div>
        </div>

        <div class="panel-form">
            <div class="form-head">
                <h2>Masuk ke sistem</h2>
                <p>Silakan masuk untuk mulai menilai dan meranking atlet.</p>
            </div>

            @if($errors->any())
                <div class="alert-box">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login.attempt') }}" method="POST">
                @csrf

                <div class="field">
                    <label for="email">Email</label>
                    <div class="field-input">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
                    </div>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <div class="field-input">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                        <button type="button" class="toggle-pass" onclick="const p=document.getElementById('password'); const i=this.querySelector('i'); const show=p.type==='password'; p.type= show ? 'text':'password'; i.className= show ? 'fa-solid fa-eye-slash':'fa-solid fa-eye';">
                            <i class="fa-solid fa-eye" style="position:static;color:#a7b2c6;"></i>
                        </button>
                    </div>
                </div>

                <div class="row-between">
                    <label class="remember">
                        <input type="checkbox" name="remember" value="1">
                        Ingat saya
                    </label>
                </div>

                <button type="submit" class="btn-login">
                    Masuk
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            <div class="form-foot">
                Akun default: <strong>admin@espa.test</strong> / <strong>password</strong>
            </div>
        </div>

    </div>

</body>
</html>