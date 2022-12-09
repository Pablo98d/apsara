@extends('layouts.master')
@section('title', 'Listado de grupos excluidos')
@section('parentPageTitle', 'Grupos')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>

@stop
@section('content')
<div class="row">
	<div class="col-md-12">
		@if ( session('status') )
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<center>
					{{ session('status') }}
				</center>
				<button class="close" type="button" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
		@endif
        @if ( session('error') )
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<center>
					{{ session('error') }}
				</center>
				<button class="close" type="button" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
		@endif
	<hr>
</div>
    </div>
    <div class="row">
        <div class="col-md-10 mb-3">
            <form id="formGrupoGerente" action="{{url('grupos/gerentes/excluir')}}" method="get">

            
                <label for=""><b>Gerentes de zona</b></label>
                <select name="id_gerente" class="form-control show-tick ms select2" onchange="buscar_grupos()" data-placeholder="Select">
                    @if (count($gerenteszona)==0)
                        Sin gerentes de zona
                    @else
                        @foreach ($gerenteszona as $gerentesz)
                            <option value="{{$gerentesz->id}}"
                                {{$id_gerente==$gerentesz->id ? 'selected' : 'Seleccione un gerente'}}
                                >#{{$gerentesz->id}} {{$gerentesz->nombre}} {{$gerentesz->ap_paterno}} {{$gerentesz->ap_materno}}  /   {{$gerentesz->email}}</option>
                        @endforeach
                        
                    @endif
                </select>
            </form>
            <form action="{{url('guardar-grupos-excluidos')}}" method="post">
                @csrf
        </div>
        
        <div class="col-md-2 mt-2"><button type="submit" onclick="return confirm('¿Esta seguro de excluir los grupos seleccionados?')" class="btn btn-primary mt-4">Excluir grupos</button></div>
        
        @if (count($zonas)==0)
            <div class="col-md-10">
                <center>
                    Seleccione un gerente de zona
                </center>
            </div>
        @else
            @foreach ($zonas as $zona)
            <div class="col-md-12"><hr>
                
                    
                    <label for=""><b>Zona</b></label>
                    <input type="text" value="#{{$zona->IdZona}} {{$zona->Zona}}" class="form-control" disabled>
                    <label for="" class="mt-2"><b>Grupos</b></label>
                
                    <input type="hidden" name="id_gerente_zona" value="{{$id_gerente}}">
                    <div class="row ml-4 mt-2">
                        
                            @php
                                $grupos=DB::table('tbl_grupos')
                                ->select('tbl_grupos.*')
                                ->where('IdZona','=',$zona->IdZona)
                                ->orderBy('grupo','ASC')
                                ->get();
                                
                            @endphp
                            @if (count($grupos)==0)
                                Sin grupos
                            @else
                                    @foreach ($grupos as $grupo)
                                    @php
                                        $excluido=DB::table('tbl_grupos_gerentes_excluir')
                                        ->select('tbl_grupos_gerentes_excluir.*')
                                        ->where('tbl_grupos_gerentes_excluir.id_grupo','=',$grupo->id_grupo)
                                        ->where('tbl_grupos_gerentes_excluir.id_gerente','=',$id_gerente)
                                        ->get();
                                    @endphp
                                    @if (count($excluido)==0)
                                        <div class="col-md-2 btn btn-success mr-1" style="padding: 9px; position: relative; cursor: unset">
                                            
                                            <label for="id_grupo{{$grupo->id_grupo}}" style="cursor: pointer">{{$grupo->id_grupo}} {{$grupo->grupo}}</label> 
                                            <input type="checkbox" name="id_grupo[]" value="{{$grupo->id_grupo}}" id="id_grupo{{$grupo->id_grupo}}" style="width: 17px; height: 17px;float: right; position: absolute; right: 5px;bottom: 3px;">
                                            
                                        </div>
                                    @else
                                        <div class="col-md-2 btn btn-secondary mr-1" style="padding: 9px; position: relative;">{{$grupo->id_grupo}} {{$grupo->grupo}} <br> Excluido
                                            
                                                
                                                <button onclick="incluir_grupo({{$id_gerente}},{{$grupo->id_grupo}})" type="button" style="color: red; font-size: 16px; margin: 0; background: transparent;  border: 0;font-weight: bold;float: right; position: absolute; right: 5px;bottom: 3px;">X</button>
                                            
                                        </div>
                                    @endif
                                    @endforeach
                                    
                                
                            @endif
                    </div>
                
            </div>
            @endforeach

        @endif
    </form>
        <form id="formIncluir_grupo" action="{{url('guardar-grupos-incluir')}}" method="post">
            @csrf
        </form>
    </div>
@stop
@section('page-script')
<script>
    function incluir_grupo(id_gerente,id_grupo)
        { 
            var tfP1 = document.createElement("INPUT");
            tfP1.name="id_gerente";
            tfP1.type="hidden";
            tfP1.value=id_gerente;

            var tfP2 = document.createElement("INPUT");
            tfP2.name="id_grupo";
            tfP2.type="hidden";
            tfP2.value=id_grupo;
                
            var padre=document.getElementById("formIncluir_grupo");
            // padre.appendChild(tfAccion);
            padre.appendChild(tfP1);
            padre.appendChild(tfP2);
            
            var resultado = window.confirm('¿Esta seguro de incluir el grupo?');
            if (resultado === true) {
                document.getElementById("formIncluir_grupo").submit();
            } else { 
                
            }

            
        }
</script>
<script>
    function buscar_grupos(){

      document.getElementById("formGrupoGerente").submit();
  
  }
</script>
<script>
	window.onload = function agregar_boton_atras(){
  
	  document.getElementById('Atras').innerHTML='<a href="{{ route('home') }}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
  
  }
  </script>

<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop