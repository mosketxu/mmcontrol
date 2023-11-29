<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <script src="{{ asset('js/app.js') }}" defer></script>

    <title>{{$details['title']}}</title>

</head>
<body class="font-sans antialiased">
    <h2 class="text-2xl font-semibold text-gray-900">
        @if($presupuesto->tipo=='1')
            Presupuesto Editorial:
        @elseif($presupuesto->tipo=='2')
            Presupuesto Packaging :
        @else
            Presupuesto Propios :
        @endif
        <a class="text-blue-700 underline" href="{{ route('presupuesto.editar',[$presupuesto,'i']) }}">{{$presupuesto->id   }}</a>
    </h2>
    <div class="">
        <div class="p-1 m-1 space-y-1">
            <div class="">
                <x-jet-label for="prespuesto">{{ __('Presupuesto: ') }} {{$presupuesto->id}}</x-jet-label>
            </div>
            <div class="">
                <x-jet-label for="fechapresupuesto">{{ __('Fecha presupuesto: ') }} {{$presupuesto->fechapresupuesto}}</x-jet-label>
            </div>
            <div class="">
            <div class="">
                <x-jet-label for="cliente_id">{{ __('Cliente: ') }} {{$presupuesto->cliente->entidad}}</x-jet-label>
            </div>
            <div class="">
                <x-jet-label for="contacto_id">{{ __('Contacto: ') }} {{$presupuesto->contacto->entidad ?? '-'}}</x-jet-label>
            </div>
            <div class="">
                <x-jet-label for="contacto_id">{{ __('Responsable: ') }} {{$presupuesto->responsable}}</x-jet-label>
                <p class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></p>
            </div>
            <br>
            <div>
                <x-jet-label >{{ __('Ok Externos ') }} {{$presupuesto->okexterno=='0' ? "No" : 'Sí'}}</x-jet-label>
            </div>
            <div>
                <x-jet-label >{{ __('Observaciones Externas: ') }} </x-jet-label>
                <p>{!! nl2br(e($presupuesto->observacionesexterno)) !!}</p>
            </div>
        </div>
    </div>
</body>
</html>




