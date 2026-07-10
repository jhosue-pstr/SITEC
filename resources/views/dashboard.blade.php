@php
    use App\Models\Tarea;
    use App\Models\Usuario;

    $user = auth()->user();
    $rol = $user->rol;

    $baseQuery = Tarea::with(['oficina', 'solicitante', 'practicanteAsignado']);

    if ($rol === 'jefe') {
        $pendientes = (clone $baseQuery)->where('estado', 'pendiente')->get();
        $enProceso = (clone $baseQuery)->whereIn('estado', ['asignado', 'en_proceso'])->get();
        $observadas = (clone $baseQuery)->where('estado', 'observado')->get();
        $finalizadas = (clone $baseQuery)->where('estado', 'finalizado')->get();
        $countPracticantesActivos = Usuario::where('rol', 'practicante')->where('activo', true)->count();
    } elseif ($rol === 'practicante') {
        $pendientes = (clone $baseQuery)->where('estado', 'pendiente')
            ->orWhere(function($q) use ($user) {
                $q->where('practicante_asignado_id', $user->id)->where('estado', 'pendiente');
            })->get();
        $enProceso = (clone $baseQuery)->where('practicante_asignado_id', $user->id)
            ->whereIn('estado', ['asignado', 'en_proceso'])->get();
        $observadas = (clone $baseQuery)->where('practicante_asignado_id', $user->id)
            ->where('estado', 'observado')->get();
        $finalizadas = (clone $baseQuery)->where('practicante_asignado_id', $user->id)
            ->where('estado', 'finalizado')->get();
        $countPracticantesActivos = null;
    } else {
        $pendientes = (clone $baseQuery)->where('solicitante_id', $user->id)->where('estado', 'pendiente')->get();
        $enProceso = (clone $baseQuery)->where('solicitante_id', $user->id)->whereIn('estado', ['asignado', 'en_proceso'])->get();
        $observadas = (clone $baseQuery)->where('solicitante_id', $user->id)->where('estado', 'observado')->get();
        $finalizadas = (clone $baseQuery)->where('solicitante_id', $user->id)->where('estado', 'finalizado')->get();
        $countPracticantesActivos = null;
    }

    $countPendientes = $pendientes->count();
    $countEnProceso = $enProceso->count();
    $countFinalizadasMes = Tarea::where('estado', 'finalizado')->whereMonth('fecha_finalizacion', now()->month)->count();
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tablero de solicitudes</h2>
                <p class="text-sm text-gray-500">Control de tareas, practicantes y evidencias de soporte técnico.</p>
            </div>
            <a href="/tareas/create" class="bg-green-700 text-white px-4 py-2 rounded-lg font-bold hover:bg-green-800">+ Nueva solicitud</a>
        </div>
    </x-slot>

    <div class="flex-1 flex flex-col min-h-0 px-4" style="max-width:1400px;margin:auto;padding-top:16px;padding-bottom:16px">
        <style>
            :root{--primary:#166534;--bg:#f4f7f5;--card:#fff;--muted:#64748b;--line:#dbe4de}
            .stats{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:16px}.stat{background:var(--card);padding:18px;border:1px solid var(--line);border-radius:12px}.stat b{font-size:28px}.stat span{display:block;color:var(--muted);font-size:14px;margin-top:6px}
            .filters{background:white;padding:14px;border:1px solid var(--line);border-radius:12px;display:flex;gap:10px;margin-bottom:16px;flex-wrap:wrap}
            .filters select,.filters input{padding:10px;border:1px solid var(--line);border-radius:8px;background:white;font-size:14px}
            .filters input{flex:1;min-width:200px}
            .board{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;flex:1;min-height:0}.column{background:#eaf0ec;border-radius:12px;padding:12px;height:100%;overflow-y:auto}.column h3{margin:3px 0 13px;font-size:15px}.count-badge{float:right;background:white;padding:2px 8px;border-radius:99px;font-size:12px}
            .task{background:white;border:1px solid var(--line);border-radius:10px;padding:13px;margin-bottom:10px;box-shadow:0 1px 2px #00000008}.task h4{margin:0 0 8px;font-size:15px;line-height:1.3}.task small{display:block;color:var(--muted);margin:5px 0;font-size:13px}.tag{display:inline-block;border-radius:99px;padding:4px 8px;font-size:11px;font-weight:bold;margin-bottom:6px}.high{background:#fee2e2;color:#b91c1c}.medium{background:#fef3c7;color:#92400e}.low{background:#dcfce7;color:#166534}
            .btn-secondary{display:inline-block;border:0;border-radius:8px;padding:8px 12px;font-weight:700;font-size:13px;cursor:pointer;background:#e8f2ea;color:var(--primary);text-decoration:none;margin-top:4px}.btn-secondary:hover{background:#d4e6d8}
            .empty-column{color:var(--muted);font-size:14px;text-align:center;padding:30px 0}
            @media(max-width:1024px){.board{grid-template-columns:1fr 1fr}}@media(max-width:640px){.stats,.board{grid-template-columns:1fr}}
        </style>

        <div class="filters">
            <input type="text" id="searchInput" placeholder="Buscar por código, oficina o problema..." onkeyup="filterBoard()">
            <select id="statusFilter" onchange="filterBoard()">
                <option value="">Todos los estados</option>
                <option value="pendiente">Pendiente</option>
                <option value="proceso">En proceso</option>
                <option value="observado">Observado</option>
                <option value="finalizado">Finalizada</option>
            </select>
            <select id="priorityFilter" onchange="filterBoard()">
                <option value="">Todas las prioridades</option>
                <option value="critica">Crítica</option>
                <option value="alta">Alta</option>
                <option value="media">Media</option>
                <option value="baja">Baja</option>
            </select>
        </div>

        <section class="stats">
            <div class="stat"><b>{{ $countPendientes }}</b><span>Pendientes</span></div>
            <div class="stat"><b>{{ $countEnProceso }}</b><span>En proceso</span></div>
            <div class="stat"><b>{{ $countFinalizadasMes }}</b><span>Finalizadas (este mes)</span></div>
            @if($countPracticantesActivos !== null)
            <div class="stat"><b>{{ $countPracticantesActivos }}</b><span>Practicantes activos</span></div>
            @else
            <div class="stat"><b>—</b><span>Practicantes activos</span></div>
            @endif
        </section>

        <section class="board" id="board">
            <div class="column" data-column="pendiente">
                <h3>🟡 Pendientes <span class="count-badge">{{ $countPendientes }}</span></h3>
                @forelse($pendientes as $tarea)
                    <x-task-card :tarea="$tarea" />
                @empty
                    <div class="empty-column">Sin tareas pendientes</div>
                @endforelse
            </div>

            <div class="column" data-column="proceso">
                <h3>🔵 En proceso <span class="count-badge">{{ $countEnProceso }}</span></h3>
                @forelse($enProceso as $tarea)
                    <x-task-card :tarea="$tarea" />
                @empty
                    <div class="empty-column">Sin tareas en proceso</div>
                @endforelse
            </div>

            <div class="column" data-column="observado">
                <h3>🟣 Observadas <span class="count-badge">{{ $observadas->count() }}</span></h3>
                @forelse($observadas as $tarea)
                    <x-task-card :tarea="$tarea" />
                @empty
                    <div class="empty-column">Sin tareas observadas</div>
                @endforelse
            </div>

            <div class="column" data-column="finalizado">
                <h3>🟢 Finalizadas <span class="count-badge">{{ $finalizadas->count() }}</span></h3>
                @forelse($finalizadas as $tarea)
                    <x-task-card :tarea="$tarea" />
                @empty
                    <div class="empty-column">Sin tareas finalizadas</div>
                @endforelse
            </div>
        </section>
    </div>

    <script>
    function filterBoard() {
        const search = document.getElementById('searchInput').value.toLowerCase();
        const status = document.getElementById('statusFilter').value;
        const priority = document.getElementById('priorityFilter').value;

        document.querySelectorAll('.column').forEach(col => {
            col.querySelectorAll('.task').forEach(task => {
                const text = task.textContent.toLowerCase();
                const matchesSearch = !search || text.includes(search);
                const matchesStatus = !status || col.dataset.column === status;
                const taskPriority = task.querySelector('.tag')?.textContent.trim().toLowerCase() || '';
                const matchesPriority = !priority || taskPriority === priority || taskPriority === priority.toUpperCase();

                task.style.display = matchesSearch && matchesStatus && matchesPriority ? '' : 'none';
            });
        });
    }
    </script>
</x-app-layout>
