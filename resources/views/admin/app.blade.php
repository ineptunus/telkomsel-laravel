<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Telkomsel X Analytics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

    
        body {
            background: #f4f7fb;
            color: #1f2937;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 240px;
            background: #050b14;
            color: white;
            padding: 20px 14px;
            position: fixed;
            height: 100vh;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        .brand-icon {
            background: #0ea5e9;
            padding: 10px 13px;
            border-radius: 8px;
            font-weight: bold;
        }

        .brand h3 {
            font-size: 16px;
        }

        .brand p {
            font-size: 11px;
            color: #94a3b8;
        }

        .menu a {
            display: block;
            color: #cbd5e1;
            text-decoration: none;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .menu a.active,
        .menu a:hover {
            background: #0ea5e9;
            color: white;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 20px;
            left: 14px;
            right: 14px;
            background: #0f172a;
            padding: 12px;
            border-radius: 8px;
            font-size: 12px;
            color: #94a3b8;
        }

        .main {
            margin-left: 240px;
            width: calc(100% - 240px);
            padding: 24px;
        }

        .topbar {
            background: white;
            padding: 16px 22px;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
            box-shadow: 0 2px 10px rgba(0,0,0,.04);
        }

        .topbar h2 {
            font-size: 18px;
            color: #0f172a;
        }

        .admin-info {
            font-size: 13px;
            text-align: right;
        }

        .avatar {
            background: #0ea5e9;
            color: white;
            padding: 8px 11px;
            border-radius: 50%;
            margin-left: 10px;
        }

        .page-title {
            margin-bottom: 20px;
        }

        .page-title h1 {
            font-size: 24px;
            margin-bottom: 6px;
        }

        .page-title p {
            color: #64748b;
            font-size: 14px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 22px;
        }

        .card {
            background: white;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,.04);
        }

        .card h4 {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 10px;
        }

        .card .number {
            font-size: 28px;
            font-weight: bold;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            margin-bottom: 22px;
        }

        .chart-box {
            background: white;
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 22px;
            box-shadow: 0 2px 10px rgba(0,0,0,.04);
        }

        .chart-box h3 {
            font-size: 16px;
            margin-bottom: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            font-size: 13px;
        }

        th, td {
            padding: 13px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        th {
            background: #f8fafc;
            color: #475569;
        }

        .badge {
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 12px;
        }

        .green { background: #dcfce7; color: #15803d; }
        .red { background: #fee2e2; color: #b91c1c; }
        .orange { background: #ffedd5; color: #c2410c; }
        .blue { background: #dbeafe; color: #1d4ed8; }
        .purple { background: #f3e8ff; color: #7e22ce; }

        .btn {
            display: inline-block;
            border: none;
            background: #0ea5e9;
            color: white;
            padding: 11px 18px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
        }

        .form-control {
            width: 100%;
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            margin-bottom: 14px;
        }
    </style>
</head>

<body>
<div class="wrapper">

    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon">T</div>
            <div>
                <h3>Telkomsel X</h3>
                <p>Analytics Platform</p>
            </div>
        </div>

        <nav class="menu">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('admin.statistik') }}" class="{{ request()->routeIs('admin.statistik') ? 'active' : '' }}">Statistik Kepuasan</a>
            <a href="{{ route('admin.sarcasm') }}" class="{{ request()->routeIs('admin.sarcasm') ? 'active' : '' }}">Tren Sarcasm</a>
            <a href="{{ route('admin.hate') }}" class="{{ request()->routeIs('admin.hate') ? 'active' : '' }}">Tren Hate Speech</a>
            <a href="{{ route('admin.export') }}" class="{{ request()->routeIs('admin.export') ? 'active' : '' }}">Export Data</a>
        </nav>

        <div class="sidebar-footer">

    <div style="margin-bottom:15px;">
        <strong>Tanggal Hari Ini</strong><br>
        {{ now()->format('d F Y') }}
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf

        <button
            type="submit"
            style="
                width:100%;
                background:#ef4444;
                color:white;
                border:none;
                padding:10px;
                border-radius:8px;
                cursor:pointer;
                font-weight:bold;
            ">
            Logout
        </button>
    </form>

</div>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <h2>Telkomsel Analytics Platform</h2>
                <small>Sistem analisis kepuasan pelanggan Telkomsel di platform X</small>
            </div>

          <div class="admin-info" style="display:flex; align-items:center; gap:10px;">
    <div>
        <strong>{{ session('admin_name') ?? 'Admin Dashboard' }}</strong><br>
        <small>{{ session('admin_email') ?? 'admin@telkomsel.co.id' }}</small>
    </div>

    <span class="avatar">A</span>

    <form action="{{ route('logout') }}" method="POST" style="margin:0;">
        @csrf
        <button type="submit" class="btn" style="background:#ef4444; padding:8px 12px;">
            Logout
        </button>
    </form>
</div>
        </div>

        @yield('content')
    </main>

</div>

@yield('script')
</body>
</html>