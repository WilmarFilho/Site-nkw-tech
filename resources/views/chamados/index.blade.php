
@extends('layouts.bg_foto')


@section('content')

    <div class='container'>
    
    <div class='text-center row justify-content-center'>
        
        <button id='btn-filtro' class='btn btn-outline-light btn-block col-4 label-filtro' type='button' data-toggle='collapse' data-target='#filtro'> Filtro  <i class="fa-solid fa-filter"></i> </button>
        

        <div class='collapse row  mt-4 justify-content-center' id='filtro'>
            <form class='col-5 form-inline' action='/chamado'>
                <label class='label-form'>Selecione o status de chamado para a consulta</label>
                <div class='row'>
                    <div class='col-8'>
                        <select name='filtro' class='form-control'>
                            <option value=''>Todos</option>
                            <option>Pendente</option>
                            <option>Andamento</option>
                            <option>Finalizado</option>
                        </select>
                    </div>

                    <div class='col-4'>
                        <button type='submit' class='btn btn-danger'>Procurar <i class="fa-solid fa-magnifying-glass"></i> </button>
                    </div>
                </div>
            </form>
        </div>
    
    </div>

    @foreach($chamados as $indice => $chamado)
        <chamados-component id={{$chamado->id}}  tipo={{$chamado->tipo_serviço}}  status=<?=$chamado->status?> >
           
            @php 
                $dataHora = explode(" ",$chamado->created_at);
                
                $data = explode("-", $dataHora[0]);
                $data = $data[2] . '/' . $data[1] . '/' . $data[0];
                
                $hora = explode(":", $dataHora[1]);
                $hora = $hora[0] . ':' . $hora[1];
            @endphp


            <template v-slot:data> 
                <h5 id='data-hora' class="ms-auto me-4 mt-1">{{$data}}-{{$hora}} </h5>
            </template>
            
            <template v-slot:descricao> 
                <p class="card-text texto-chamado">{{$chamado->descricao}}</p>
            </template>

             <template v-slot:button> 
                <a href={{route('chamado.show', $chamado)}} class="btn btn-danger">Ver Chamado</a>
            </template>

        </chamados-component>

     @endforeach

    <div class='text-center row justify-content-center'>
      
         {{$chamados->links()}}
       
    </div>

     <div id='home'>

         <a href={{route('home')}}><i class="fa-solid fa-house fa-2x"></i> </a>
     
     </div>

    </div>

@endsection