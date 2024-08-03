@extends('layouts.app')
@section('title', __('system.tables.menu'))
@push('page_css')
    <style>
        .data-description {
            text-overflow: clip;
            max-height: 50px;
            min-height: 50px;
            overflow: hidden;
        }
    </style>
@endpush
@section('content')

 <div class="row">
   <div class="col-lg-12">
        <!-- Fila de botones horizontales -->
        <div class="btn-group-horizontal">
            <a href="#" class="btn btn-primary">Sala principal</a>
            <a href="#" class="btn btn-primary">Sala 2</a>
            <a href="#" class="btn btn-primary">Terraza 1</a>
            <a href="#" class="btn btn-primary" style="margin-right: 50px;">Terraza 2</a>
            <a href="#" class="btn btn-secondary">Añadir mesa</a>
            <a href="#" class="btn btn-secondary">Eliminar mesa</a>
            <a href="#" class="btn btn-secondary">Crear una reserva</a>
            <a href="https://appclubpay.com/pos/new" class="btn btn-secondary"> Ir a POS </a>
           <br/>
           <br/>

        <!-- Área donde se puede arrastrar y soltar el círculo -->
        <div class="drop-area" id="dropArea">
            <!-- Los círculos se agregarán aquí -->
        </div>

  <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6 col-xl-6">
                                <h4 class="card-title">Sala principal del restaurante</h4>
                                <div class="page-title-box pb-0 d-sm-flex">
                                    <div class="page-title-right">
                                        <!-- Aquí puedes agregar botones u otros elementos si es necesario -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-4">
                                    <!-- Formulario para seleccionar imagen -->
                                    <form>
                                        <div class="form-group">
                                            <label for="photoUpload">Seleccionar foto para ver:</label>
                                            <input type="file" class="form-control-file" id="photoUpload" accept="image/*">
                                        </div>
                                    </form>
                                    <div id="previewContainer">
                                        <img id="preview" src="" alt="Vista previa de la imagen">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
          
    <script>
        document.getElementById('photoUpload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            } else {
                document.getElementById('preview').src = '';
            }
        });
    </script>

    <script>
        document.getElementById('photoUpload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            } else {
                document.getElementById('preview').src = '';
            }
        });
    </script>
</body>
    <script>
        document.getElementById('photoUpload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            } else {
                document.getElementById('preview').src = '';
            }
        });
    </script>
</body>
          
<br/>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.tables.menu') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.tables.menu') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        @can('add tables')
                            <div class="col-md-6 col-xl-6 text-end add-new-btn-parent">
                                <a href="{{ route('restaurant.tables.create') }}" class="btn btn-primary btn-rounded waves-effect waves-light"><i class="bx bx-plus me-1"></i>{{ __('system.crud.add_new') }}</a>
                            </div>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-4">
                                <div id="restaurants_list" class="dataTables_wrapper dt-bootstrap4 no-footer table_filter">
                                    <div id="data-preview" class='overflow-hidden'>
                                        @include('restaurant.tables.table')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
