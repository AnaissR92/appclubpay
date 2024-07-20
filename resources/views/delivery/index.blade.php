<!-- resources/views/delivery/index.blade.php -->
@extends('layouts.app')

@section('title', 'Delivery')

@section('content')
<h1>Bienvenido a Delivery</h1>
<h4>Supervise los análisis y las estadísticas de su negocio</h4>
    
    <!-- Cuadrado Grande -->
    <div class="square-panel">
        
    </div>

   <!-- Contenedor de Botones -->
<div class="card card-body mb-3">
    <div class="row justify-content-between align-items-center g-2 mb-3">
        <div class="col-auto">
            <h4 class="d-flex align-items-center gap-10 mb-0">Analítica del delivery</h4>
        </div>
        <div class="col-auto">
            <select class="custom-select min-w200" name="statistics_type" onchange="order_stats_update(this.value)">
                <option value="overall">Todas las estadísticas</option>
                <option value="today">Estadísticas de hoy</option>
                <option value="this_month">Estadísticas de este mes</option>
            </select>
        </div>
    </div>
    
    <div class="row g-2" id="order_stats">
        <div class="col-sm-6 col-lg-3">
            <a href="" class="dashboard--card">
                <h5 class="dashboard--card__subtitle">Pendiente</h5>
                <h2 class="dashboard--card__title">25</h2>
                <img width="30" src="" class="dashboard--card__img" alt="">
            </a>
        </div>
        <div class="col-sm-6 col-lg-3">
            <a href="" class="dashboard--card">
                <h5 class="dashboard--card__subtitle">Confirmado</h5>
                <h2 class="dashboard--card__title">17</h2>
                <img width="30" src="" class="dashboard--card__img" alt="">
            </a>
        </div>
        <div class="col-sm-6 col-lg-3">
            <a href="" class="dashboard--card">
                <h5 class="dashboard--card__subtitle">Procesando</h5>
                <h2 class="dashboard--card__title">5</h2>
                <img width="30" src="" class="dashboard--card__img" alt="">
            </a>
        </div>
        <div class="col-sm-6 col-lg-3">
            <a href="" class="dashboard--card">
                <h5 class="dashboard--card__subtitle">Entregado</h5>
                <h2 class="dashboard--card__title">3</h2>
                <img width="30" src="" class="dashboard--card__img" alt="">
            </a>
        </div>
        <div class="col-sm-6 col-lg-3">
            <a class="order-stats order-stats_pending" href="">
                <div class="order-stats__content">
                    <img width="20" src="" class="order-stats__img" alt="">
                    <h6 class="order-stats__subtitle">En reparto</h6>
                </div>
                <span class="order-stats__title">22</span>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3">
            <a class="order-stats order-stats_canceled" href="">
                <div class="order-stats__content">
                    <img width="20" src="" class="order-stats__img" alt="">
                    <h6 class="order-stats__subtitle">Cancelado</h6>
                </div>
                <span class="order-stats__title">3</span>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3">
            <a class="order-stats order-stats_returned" href="">
                <div class="order-stats__content">
                    <img width="20" src="" class="order-stats__img" alt="">
                    <h6 class="order-stats__subtitle">Devuelto</h6>
                </div>
                <span class="order-stats__title">1</span>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3">
            <a class="order-stats order-stats_failed" href="">
                <div class="order-stats__content">
                    <img width="20" src="" class="order-stats__img" alt="">
                    <h6 class="order-stats__subtitle">Fallo en la entrega</h6>
                </div>
                <span class="order-stats__title">2</span>
            </a>
        </div>
    </div>
</div>

    <!-- Contenedor de la Tabla -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID del Pedido</th>
                    <th>Fecha del Pedido</th>
                    <th>Hora del Pedido</th>
                    <th>Estado del Pedido</th>
                    <th>Importe del Pedido</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí puedes añadir filas dinámicamente en el futuro -->
                <tr>
                    <td>1</td>
                    <td>20/07/2024</td>
                    <td>14:30</td>
                    <td>En curso</td>
                    <td>50.00 €</td>
                </tr>
                <!-- Añadir más filas según sea necesario -->
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('styles')
