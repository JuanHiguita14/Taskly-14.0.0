@extends('layouts.dashboard')

@section('title', 'Crear Proyecto')
@section('page-title', 'Asignar Nuevo Proyecto')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Asignar Nuevo Proyecto</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Crea un nuevo proyecto para tus estudiantes</p>
        </div>
        
        <form method="POST" action="{{ route('teacher.create-project.store') }}" class="p-6" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Estudiante -->
                <div class="md:col-span-2">
                    <label for="student_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Estudiante <span class="text-red-500">*</span>
                    </label>
                    <select id="student_id" name="student_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Seleccionar estudiante</option>
                        @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->name }} {{ $student->last_name }}
                        </option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Curso -->
                <div class="md:col-span-2">
                    <label for="course_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Curso <span class="text-red-500">*</span>
                    </label>
                    <select id="course_id" name="course_id" required disabled
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Primero selecciona un estudiante</option>
                    </select>
                    @error('course_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Nombre del Proyecto -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Nombre del Proyecto <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                           placeholder="Ej: Sistema de Gestión de Inventario">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Descripción -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Descripción
                    </label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                              placeholder="Describe los objetivos y requisitos del proyecto...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Fecha de Finalización -->
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Fecha de Finalización <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('end_date')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Prioridad -->
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Prioridad <span class="text-red-500">*</span>
                    </label>
                    <select id="priority" name="priority" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Seleccionar prioridad</option>
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Baja</option>
                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Media</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Alta</option>
                    </select>
                    @error('priority')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Material de apoyo (opcional) -->
            <div class="mt-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Material de apoyo (opcional)</label>
                <input type="file" name="support_file" accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png,.gif,.zip,.rar"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PDF, DOC, DOCX, TXT, JPG, PNG, GIF, ZIP, RAR (máx. 10MB)</p>
            </div>

            <!-- Subtareas del Proyecto -->
            <div class="mt-6">
                <div class="flex items-center justify-between mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Subtareas del Proyecto (opcional)
                    </label>
                    <button type="button" id="addSubtaskBtn" 
                            class="px-3 py-1.5 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">
                        <i class="fas fa-plus mr-1"></i> Agregar Subtarea
                    </button>
                </div>
                <div id="subtasksContainer" class="space-y-3">
                    <!-- Las subtareas se agregarán aquí dinámicamente -->
                </div>
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    Puedes agregar las subtareas que el estudiante deberá completar. El estudiante solo podrá subir archivos a estas subtareas.
                </p>
            </div>
            
            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('teacher.projects') }}" 
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    <i class="fas fa-project-diagram mr-2"></i> Asignar Proyecto
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const studentSelect = document.getElementById('student_id');
    const courseSelect = document.getElementById('course_id');
    const oldCourseId = @json(old('course_id'));
    
    studentSelect.addEventListener('change', function() {
        const studentId = this.value;
        
        if (!studentId) {
            courseSelect.innerHTML = '<option value="">Primero selecciona un estudiante</option>';
            courseSelect.disabled = true;
            return;
        }
        
        // Mostrar loading
        courseSelect.innerHTML = '<option value="">Cargando cursos...</option>';
        courseSelect.disabled = true;
        
        // Hacer petición AJAX para obtener los cursos del estudiante
        fetch(`/teacher/students/${studentId}/courses`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            courseSelect.innerHTML = '<option value="">Seleccionar curso</option>';
            
            if (data.length === 0) {
                courseSelect.innerHTML += '<option value="">Este estudiante no tiene cursos asignados</option>';
            } else {
                data.forEach(course => {
                    const option = document.createElement('option');
                    option.value = course.id;
                    option.textContent = course.name;
                    if (oldCourseId && oldCourseId == course.id) {
                        option.selected = true;
                    }
                    courseSelect.appendChild(option);
                });
            }
            
            courseSelect.disabled = false;
        })
        .catch(error => {
            console.error('Error:', error);
            courseSelect.innerHTML = '<option value="">Error al cargar los cursos</option>';
            courseSelect.disabled = true;
        });
    });
    
    // Si hay un estudiante seleccionado previamente (después de un error de validación), cargar sus cursos
    if (studentSelect.value) {
        studentSelect.dispatchEvent(new Event('change'));
    }

    // Contador para las subtareas
    let subtaskCounter = 0;

    // Función para agregar subtarea
    function addSubtask() {
        subtaskCounter++;
        const container = document.getElementById('subtasksContainer');
        const subtaskDiv = document.createElement('div');
        subtaskDiv.className = 'border border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700';
        subtaskDiv.id = `subtask-${subtaskCounter}`;
        
        subtaskDiv.innerHTML = `
            <div class="flex items-start justify-between mb-3">
                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Subtarea ${subtaskCounter}</h4>
                <button type="button" class="remove-subtask-btn text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" data-subtask-id="${subtaskCounter}">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Título de la subtarea</label>
                    <input type="text" name="subtasks[${subtaskCounter}][title]" 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md text-sm"
                           placeholder="Ej: Análisis de requisitos" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Descripción (opcional)</label>
                    <textarea name="subtasks[${subtaskCounter}][description]" rows="2"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md text-sm"
                              placeholder="Descripción de la subtarea..."></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Fecha límite (opcional)</label>
                        <input type="date" name="subtasks[${subtaskCounter}][due_date]" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Prioridad</label>
                        <select name="subtasks[${subtaskCounter}][priority]" 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md text-sm">
                            <option value="1">Muy Baja</option>
                            <option value="2" selected>Baja</option>
                            <option value="3">Media</option>
                            <option value="4">Alta</option>
                            <option value="5">Muy Alta</option>
                        </select>
                    </div>
                </div>
            </div>
        `;
        
        container.appendChild(subtaskDiv);
        
        // Agregar event listener al botón de eliminar
        const removeBtn = subtaskDiv.querySelector('.remove-subtask-btn');
        removeBtn.addEventListener('click', function() {
            const id = this.getAttribute('data-subtask-id');
            removeSubtask(id);
        });
    }

    // Función para eliminar subtarea
    function removeSubtask(id) {
        const subtaskDiv = document.getElementById(`subtask-${id}`);
        if (subtaskDiv) {
            subtaskDiv.remove();
        }
    }

    // Event listener para el botón de agregar subtarea
    const addSubtaskBtn = document.getElementById('addSubtaskBtn');
    if (addSubtaskBtn) {
        addSubtaskBtn.addEventListener('click', function() {
            addSubtask();
        });
    }

    // Delegación de eventos para los botones de eliminar (por si se agregan dinámicamente)
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-subtask-btn')) {
            const btn = e.target.closest('.remove-subtask-btn');
            const id = btn.getAttribute('data-subtask-id');
            removeSubtask(id);
        }
    });
});
</script>
@endsection
