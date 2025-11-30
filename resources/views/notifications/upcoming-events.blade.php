@extends('layouts.dashboard')

@section('title', 'Eventos Próximos')
@section('page-title', 'Eventos Próximos')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <i class="fas fa-calendar-check text-indigo-600 dark:text-indigo-400"></i>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Eventos Próximos</h3>
            <span class="ml-2 px-2 py-1 bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 rounded-full text-xs font-medium">
                {{ count($events) }}
            </span>
        </div>
        <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" title="Volver al dashboard">
            <i class="fas fa-arrow-left"></i>
        </a>
    </div>
    
    <div class="divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($events as $event)
        <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200">
            <div class="flex items-start space-x-4">
                <!-- Icono según tipo -->
                <div class="flex-shrink-0">
                    @if($event['type'] === 'task')
                        <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                            <i class="fas fa-tasks text-blue-600 dark:text-blue-400 text-xl"></i>
                        </div>
                    @elseif($event['type'] === 'project')
                        <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                            <i class="fas fa-project-diagram text-green-600 dark:text-green-400 text-xl"></i>
                        </div>
                    @else
                        <div class="w-12 h-12 rounded-full bg-amber-100 dark:bg-amber-900 flex items-center justify-center">
                            <i class="fas fa-bell text-amber-600 dark:text-amber-400 text-xl"></i>
                        </div>
                    @endif
                </div>
                
                <!-- Contenido -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $event['title'] }}
                            </h4>
                            <div class="flex items-center space-x-4 mt-2 flex-wrap">
                                <!-- Fecha -->
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ \Carbon\Carbon::parse($event['date'])->format('d/m/Y') }}
                                </span>
                                
                                <!-- Tiempo restante -->
                                @php
                                    $daysUntilDue = max(0, min(999, (int)($event['days_until_due'] ?? 0)));
                                @endphp
                                <span class="text-sm font-medium 
                                    @if($daysUntilDue === 0) text-red-600 dark:text-red-400
                                    @elseif($daysUntilDue === 1) text-orange-600 dark:text-orange-400
                                    @else text-blue-600 dark:text-blue-400 @endif">
                                    @if($daysUntilDue === 0)
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        ¡Vence HOY!
                                    @elseif($daysUntilDue === 1)
                                        <i class="fas fa-clock mr-1"></i>
                                        Vence mañana
                                    @else
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $daysUntilDue }} días restantes
                                    @endif
                                </span>
                                
                                <!-- Curso -->
                                @if(isset($event['course']) && $event['course'])
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                        <i class="fas fa-book mr-1"></i>
                                        {{ $event['course'] }}
                                    </span>
                                @endif
                                
                                <!-- Prioridad (solo para tareas) -->
                                @if(isset($event['priority']) && $event['type'] === 'task')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($event['priority'] === 'high') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        @elseif($event['priority'] === 'medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @endif">
                                        <i class="fas fa-flag mr-1"></i>
                                        {{ ucfirst($event['priority']) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Botón Ver -->
                        <div class="ml-4">
                            <a href="{{ $event['url'] }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium transition-colors">
                                <i class="fas fa-eye mr-2"></i>
                                Ver detalles
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="p-12 text-center">
            <div class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500">
                <i class="fas fa-calendar-check text-4xl"></i>
            </div>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No hay eventos próximos</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Las notificaciones aparecerán aquí cuando tengas eventos próximos.
            </p>
            <div class="mt-6">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    <i class="fas fa-arrow-left mr-2"></i> Volver al Dashboard
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection

