<head>
    <title>KasirCerdas | 404 Not Found</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
            color: #ffffff;
            margin: 0;
        }

        body {
            width: 100vw;
            height: 100dvh;
            background-color: #030712;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        img {
            width: 25%;
            height: auto;
        }

        .modal {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 40%;
            height: 65%;
            background-color: #111827;
            border-radius: 13px;
            border: 1px solid #161a24;
        }
        p {
            font-weight: 500;
        }
        button {
            background-color:#3b82f6;
            border-radius: 9px;
            font-weight: 600;
            width: 100%;
            height: 41px;
            cursor: pointer;
            border: none;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color:#60a5fa;
        }
        a {
            width: 80%
        }
    </style>
</head>

<body>
    <div class="modal">
        <img src="{{ asset('assets/rejected.png') }}" alt="rejected">
        {{-- <h2>{{ $exception->getMessage() }}</h2> --}}
        <h2>Anda tidak memiliki jadwal</h2>
        <p style="text-align: center; color:#cecece; font-weight:400; width: 80%">Jika Anda mengalami masalah shift, silakan hubungi admin untuk bantuan lebih lanjut.</p>
        <a href=" {{ url('/admin')}}">
            <button>
                Login Ulang
            </button>
        </a>
    </div>
</body>
