@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-200 bg-white text-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm']) !!}>