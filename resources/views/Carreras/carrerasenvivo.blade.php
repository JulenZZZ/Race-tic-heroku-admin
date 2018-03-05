@extends('layouts.app')

@section('content')


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

    <div class="container">
        <div class="row">
            <h3></h3>
        </div>
    </div>
    <div class="container ">
        <div class="row well-sm well">
            <div class="col-md-10 ">
                <h3></h3>
                @php
                    $id = Auth::user()->id;
                    $carreras = DB::table('carreras')->where("usuario_id",$id)->get();
                    $coches = DB::table('coches')->where("user_id",$id)->get();

                    foreach($coches as $dataob){

                    $marca = $dataob->marca;
                    $modelo = $dataob->modelo;
                    }

                     foreach ($carreras as $numcarrera){
                        $numidcarrera = $numcarrera->id_carrera ;
                     }

                    $arraycarreras = array();
                    $carrerasreg = DB::table('carreras_registros')->where("carrera_id",$numidcarrera)->orderBy('id_registro','desc')->get();
                    array_push($arraycarreras, $carrerasreg);




                @endphp

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Datos en vivo</h3>
                        <h3 class=" panel-title text-center">{{$marca}} {{$modelo}}</h3>
                        <div class="pull-right">
                                <span class="refrescar clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
                        <i class="glyphicon glyphicon-refresh"></i>Actualizar
                     </span>
                        </div>
                    </div>
                    <table class="table table-hover" id="dev-table">
                        <thead>
                        </thead>
                        <thead>
                        <tr>
                            <th>Velocidad</th>
                            <th>Revoluciones</th>
                            <th>Temperatura </th>
                        </tr>
                        </thead>
                        <tbody>


                        @foreach ($arraycarreras as $arrayCarrera)
                            @foreach($arrayCarrera as $object)
                                <tr>
                                    <th>{{ $object->velocidad}}</th>
                                    <th>{{ $object->revoluciones }}</th>
                                    <th>{{ $object->temperatura }}</th>
                                </tr>
                            @endforeach
                        @endforeach



                        </tbody>

                    </table>

                </div>


                @php

                    foreach($carrerasreg as $showTemp){
                        $datatemp = $showTemp->temperatura;
                    }

                @endphp

                @if($datatemp < 75)
                    <div id="errordiv" class="alert alert-danger" >
                        El motor está frio
                    </div>


                @elseif($datatemp > 75 && $datatemp < 120)
                    <div id="biendiv" class="alert alert-success">
                        El motor está en una temperatura óptima
                    </div>

                @else
                    <div id="errordiv2" class="alert alert-danger" hidden>
                        El motor esta sobrecalentado
                    </div>
                @endif
            </div>



            <canvas id="myChart" ></canvas>


        </div>

    </div>

    <script>

        $(document).ready(function(){
            setTimeout(function(){
                location.reload();
            }, 10000);
        });


    </script>

    <script>
        var ctx = document.getElementById("myChart").getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [4000,4500,5000,5500,6000,6500],
                datasets: [{

                    data: [90,100,130,120,100,85],
                    label: "Temperatura Cº",
                    borderColor: "#3e95cd",
                    fill: false
                },
                    {
                        data: [3000,3500,4500,3500,2000,2200],
                        label: "Revoluciones(RPM)",
                        borderColor: "#8e5ea2",
                        fill: false
                    }, {
                        data: [170,180,200,180,150,100],
                        label: "Velocidad(Km/h)",
                        borderColor: "#3cba9f",
                        fill: false
                    }
                ]
            },
            options: {
                title: {
                    display: true,
                    text: 'Temperatura del motor, velocidad y revoluciones a lo largo de la carrera'
                }
            }




        });
    /*
        var myChart = new Chart(ctx, {
            type: 'line',
            labels: [90,110,150,180,200,225,230],
            data: {

                datasets: [{
                    data: [90,100,130,120,100,85,50],
                    label: "Temperatura Cº",
                    borderColor: "#3e95cd",
                    fill: false
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Temperatura del motor cada 10 segundos'
                }
            }
        });
*/


        $(".refrescar").on("click",function(){

            //addData();

            location.reload();
        });

    </script>





@endsection
