@props(['disabled' => false,'selectname','color'=>'blue'])

<select name= {{$selectname}}
    {{-- {{$attributes->merge(['class'=>"text-sm py-1 border-$color-300 rounded-md shadow-sm text-gray-600 bg-white hover:border-$color-400 focus:outline-none appearance-none"]) }}> --}}
    {{$attributes->merge(['class'=>"text-xs py-1 border-gray-300 rounded-md shadow-sm   text-gray-600 focus:border-$color-300 focus:ring focus:ring-$color-200 focus:ring-opacity-50"]) }}>
    {{ $slot }}
</select>

