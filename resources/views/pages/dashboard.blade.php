@extends('layouts.app')

@section('title','Личный кабинет')

@push('styles')
    <style>

        .dashboard{
            max-width:1100px;
            margin:40px auto;
        }

        .dashboard-grid{
            display:grid;
            grid-template-columns:260px 1fr;
            gap:24px;
        }

        .dashboard-card{
            background:var(--surface);
            border-radius:var(--radius);
            padding:22px;
        }

        .profile-card{
            text-align:center;
        }

        .profile-avatar{
            width:90px;
            height:90px;
            border-radius:50%;
            background:linear-gradient(135deg,#4f8aff,#00c6a7);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:32px;
            font-weight:700;
            margin:0 auto 14px;
        }

        .profile-email{
            font-size:13px;
            color:var(--text-muted);
        }

        .balance-box{
            margin-top:18px;
            padding:14px;
            border-radius:12px;
            background:rgba(255,255,255,.04);
        }

        .balance-value{
            font-size:24px;
            font-weight:700;
        }

        .stats-grid{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:16px;
        }

        .stat-card{
            background:rgba(255,255,255,.04);
            border-radius:12px;
            padding:18px;
        }

        .stat-number{
            font-size:24px;
            font-weight:700;
        }

        .stat-label{
            font-size:13px;
            color:var(--text-muted);
        }

        .actions-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
            gap:14px;
            margin-top:16px;
        }

        .action-card{
            background:rgba(255,255,255,.04);
            padding:18px;
            border-radius:12px;
            transition:.2s;
            text-decoration:none;
            color:inherit;
        }

        .action-card:hover{
            transform:translateY(-4px);
        }

        .activity-list{
            display:flex;
            flex-direction:column;
            gap:10px;
            margin-top:10px;
        }

        .activity-item{
            background:rgba(255,255,255,.04);
            padding:12px 14px;
            border-radius:10px;
            font-size:14px;
        }

        @media (max-width:900px){

            .dashboard-grid{
                grid-template-columns:1fr;
            }

            .stats-grid{
                grid-template-columns:1fr 1fr;
            }

        }

        @media (max-width:520px){

            .stats-grid{
                grid-template-columns:1fr;
            }

        }

    </style>
@endpush



@section('content')

    <div class="container">

        <div class="dashboard">

            <div class="dashboard-grid">


                <div class="dashboard-card profile-card">

                    <div class="profile-avatar">
                        {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                    </div>

                    <h3>{{ auth()->user()->name }}</h3>

                    <div class="profile-email">
                        {{ auth()->user()->email }}
                    </div>


                    <div class="balance-box">
                        <div style="font-size:13px;color:var(--text-muted)">Баланс</div>
                        <div class="balance-value">0 ₽</div>
                    </div>

                    <div style="margin-top:18px;">
                        <a href="#" class="btn-outline" style="width:100%;display:block;text-decoration:none;">
                            Редактировать профиль
                        </a>
                    </div>

                </div>



                <div>


                    <div class="dashboard-card">

                        <h2 style="margin-bottom:14px;">Статистика</h2>

                        <div class="stats-grid">

                            <div class="stat-card">
                                <div class="stat-number">0</div>
                                <div class="stat-label">Заказы</div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-number">0</div>
                                <div class="stat-label">Курсы</div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-number">0</div>
                                <div class="stat-label">Просмотры</div>
                            </div>

                        </div>

                    </div>



                    <div class="dashboard-card" style="margin-top:22px;">

                        <h2 style="margin-bottom:10px;">Быстрые действия</h2>

                        <div class="actions-grid">

                            <a href="/pages/catalog.html" class="action-card">
                                <strong>Каталог</strong>
                                <div style="font-size:13px;color:var(--text-muted)">
                                    Перейти к продукции
                                </div>
                            </a>

                            <a href="/pages/news.html" class="action-card">
                                <strong>Новости</strong>
                                <div style="font-size:13px;color:var(--text-muted)">
                                    Последние обновления
                                </div>
                            </a>

                            <a href="#" class="action-card">
                                <strong>Мои заказы</strong>
                                <div style="font-size:13px;color:var(--text-muted)">
                                    История покупок
                                </div>
                            </a>

                            <a href="#" class="action-card">
                                <strong>Настройки</strong>
                                <div style="font-size:13px;color:var(--text-muted)">
                                    Управление аккаунтом
                                </div>
                            </a>

                        </div>

                    </div>



                    <div class="dashboard-card" style="margin-top:22px;">

                        <h2 style="margin-bottom:10px;">Активность</h2>

                        <div class="activity-list">

                            <div class="activity-item">
                                Вы вошли в личный кабинет
                            </div>

                            <div class="activity-item">
                                История действий появится здесь
                            </div>

                        </div>

                    </div>

                </div>


            </div>

        </div>

    </div>

@endsection
