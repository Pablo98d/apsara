<div class="navbar-right">
    <ul class="navbar-nav">
        <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Cerrar sesión">
            <i class="zmdi zmdi-power"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
        <li>
            <a class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-search"></i></a>
        </li>
        <li class="dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle" title="Notifications" data-toggle="dropdown" role="button">
                @php
                        $contador_notificaciones=0;
                        if (count($prospectos)==0) {
                            $contador_notificaciones+=0;
                        } else {
                            $contador_notificaciones+=1;
                        }
                        if ($contador_renovaciones==0) {
                            $contador_notificaciones+=0;
                        } else {
                            $contador_notificaciones+=1;
                        }
                        if (count($rechazado_por_cliente)==0) {
                            $contador_notificaciones+=0;
                        } else {
                            $contador_notificaciones+=1;
                        } 

                        if (count($prestamos_anticipados)==0) {
                            $contador_notificaciones+=0;
                        } else {
                            $contador_notificaciones+=1;
                        } 

                        
                @endphp
                @if ($contador_notificaciones==0)
                    <i class="zmdi zmdi-notifications"></i>
                    
                @else
                    <i class="zmdi zmdi-notifications"></i>
                    <div class="notify">
                        <span class="heartbit"></span>
                        <span class="point"></span>
                    </div>
                @endif
                
            </a>
            <ul class="dropdown-menu slideUp2">
                <li class="header">Notificaciones</li>
                <li class="body">
                    <ul class="menu list-unstyled">
                        
                        @if (count($prospectos)==0)
    
                        @else
                            <li>
                                
                                <a href="javascript:void(modal_prospecto());">
                                
                                    <div class="menu-info">
                                        <h4>{{count($prospectos)}} nuevos prospectos</h4>
                                        {{-- <p><i class="zmdi zmdi-time"></i> 14 mins ago </p> --}}
                                    </div>
                                </a>
                            </li>
                        @endif
                        @if ($contador_renovaciones==0)
        
                        @else
                            <li>
                                <a href="javascript:void(modal_renovacion());">
                                    
                                    <div class="menu-info">
                                        <h4>{{$contador_renovaciones}} renovaciones y préstamos nuevos</h4>
                                        {{-- <p><i class="zmdi zmdi-time"></i> 22 mins ago </p> --}}
                                    </div>
                                </a>
                            </li>
                        @endif
                        @if (count($rechazado_por_cliente)==0)
            
                        @else
                            <li>
                                <a href="javascript:void(modal_rechazadoporcliente());">
                                    {{-- <span style="padding: 9px; border-radius: 20px; background: red; position: absolute;">9</span> --}}
                                    <div class="menu-info">
                                        <h4> {{count($rechazado_por_cliente)}}  préstamos rechazados</h4>
                                        {{-- <p><i class="zmdi zmdi-time"></i> 3 hours ago </p> --}}
                                    </div>
                                </a>
                            </li>
                        @endif
                        @if (count($prestamos_anticipados)==0)
    
                        @else
                            <li>
                                <a href="javascript:void(modal_anticipados());">
                                    <div class="menu-info">
                                        <h4>{{count($prestamos_anticipados)}} préstamos anticipados</h4>
                                        
                                    </div>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                {{-- <li class="footer"> <a href="javascript:void(0);">View All Notifications</a> </li> --}}
            </ul>
        </li>
    </ul>
</div>
<div>
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
                  
                
            <div class="card-body">
                    <strong>Buscar cliente</strong> <br><br>
                    <form id="formClienteStatus"  action="{{url('buscar_cliente')}}" method="post">
                        @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Por datos del cliente</label>
                            <div class="input-group mb-3">
                              <input type="text" class="form-control" name="nombre_cliente" id="nombre_cliente" placeholder="Ingresa datos de cliente">
                              <div class="input-group-append">
                                <button type="submit"  class="btn btn-outline-secondary" style="background: rgb(93, 112, 196); border: transparent;" type="button"><i class="fas fa-search"></i></button>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="">Por estatus</label><br>
                            <style>
                                #id_select{
                                    margin: 0 !important;
                                    color: aqua !important;
                                }
                            </style>
                            @php
                                $estatus= DB::table('tbl_status_prestamo')
                                ->select('tbl_status_prestamo.*')
                                ->orderby('status_prestamo','ASC')
                                ->get();
                            @endphp
                            <select name="estatus" id="id_select" onchange="buscar_clientes_status()">
                                <option value="">-Seleccione-</option>
                                @if (count($estatus)==0)
                                    <option value="">Ningun resultado</option>
                                @else
                                    @foreach ($estatus as $estatu)
                                        <option value="{{$estatu->id_status_prestamo}}">{{$estatu->status_prestamo}}</option>
                                    @endforeach
                                @endif
                                {{-- <option value="">-Estatus-</option>
                                <option value="2">Activos</option>
                                <option value="6">Inactivos</option>
                                <option value="3">Morosos</option> --}}
                            </select>
                        </div>

                    </div>
                    
                    </form>
                <br>
                
            </div>
            
        </div>
    </div>
</div>
<script>
    function buscar_clientes_status()
    {
        document.getElementById("formClienteStatus").submit();
    }
</script>
    
</div>

