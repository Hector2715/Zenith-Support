<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-[#1e3d6c] uppercase tracking-tighter">
            {{ $title }}
        </h2>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-[10px] font-black uppercase">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card-zenith-form p-8 sm:p-12 leading-relaxed text-gray-600">
                
                @if($section == 'terminos')
                    <h3 class="text-[#1e3d6c] font-black uppercase mb-4">1. Uso del Software</h3>
                    <p class="mb-6 text-sm">Zunith Support es una herramienta de gestión. El usuario es responsable de la veracidad de los datos ingresados y el respaldo de su información técnica.</p>
                    
                    <h3 class="text-[#1e3d6c] font-black uppercase mb-4">2. Responsabilidad de Reparación</h3>
                    <p class="mb-6 text-sm">El taller se compromete a realizar las reparaciones bajo estándares profesionales, notificando cualquier cambio en el presupuesto mediante el sistema.</p>
                
                @elseif($section == 'privacidad')
                    <div class="flex items-center gap-4 mb-8 p-4 bg-blue-50 rounded-xl">
                        <i class="bi bi-shield-lock-fill text-3xl text-[#1e3d6c]"></i>
                        <p class="text-[10px] font-black uppercase text-[#1e3d6c]">Tus datos están cifrados y seguros bajo el protocolo Zenith.</p>
                    </div>
                    <p class="mb-6 text-sm">No compartimos bases de datos de clientes con terceros. La información recolectada (Nombre, Modelo, Falla) es estrictamente para uso operativo del taller.</p>

                @elseif($section == 'soporte')
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <div class="text-center py-10">
                        <div class="inline-block p-6 bg-[#41bcb0]/10 rounded-full mb-6">
                            <i class="bi bi-whatsapp text-6xl text-[#41bcb0]"></i>
                        </div>
                        <h3 class="text-xl font-black text-[#1e3d6c] uppercase mb-2">Soporte Directo</h3>
                        <p class="text-sm mb-8 px-4 sm:px-20 text-gray-500">
                            ¿Tienes dudas con el panel o necesitas reportar un error? Escríbenos directamente para asistirte.
                        </p>
                        
                        @php
                            $mensaje = "Hola Zunith Support, necesito ayuda técnica con mi panel del taller: " . (auth()->user()->nombre_taller ?: 'Sin nombre');
                            $url = "https://wa.me/+584122635104?text=" . urlencode($mensaje);
                        @endphp

                        <a href="{{ $url }}" target="_blank" class="btn-zenith inline-flex items-center gap-2 px-12 py-4 shadow-xl hover:shadow-[#41bcb0]/20">
                            <i class="bi bi-chat-dots-fill"></i> Iniciar Chat de Soporte
                        </a>
                    </div>

                    {{-- COLUMNA FORMULARIO --}}
                    <div>
                        <h4 class="font-black text-[#1e3d6c] uppercase text-sm mb-4">Reportar Problema</h4>
                        <form action="{{ route('soporte.send') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="text-[9px] font-black uppercase text-gray-400">Asunto</label>
                                <input type="text" name="asunto" class="input-zenith w-full text-xs" placeholder="Ej: Error al generar ticket">
                            </div>
                            <div>
                                <label class="text-[9px] font-black uppercase text-gray-400">Mensaje Detallado</label>
                                <textarea name="mensaje" rows="4" class="input-zenith w-full text-xs" placeholder="Describe lo que sucede..."></textarea>
                            </div>
                            <button type="submit" class="bg-[#1e3d6c] text-white w-full py-3 rounded-xl font-black uppercase text-[10px] tracking-widest hover:bg-[#41bcb0] transition-all">
                                Enviar Ticket por Correo
                            </button>
                        </form>
                    </div>
                @endif

                <div class="mt-12 pt-8 border-t border-gray-100 flex justify-between items-center">
                    <span class="text-[9px] font-black uppercase text-gray-400">Zunith Support Document v2.0</span>
                    <a href="{{ route('dashboard') }}" class="text-[#41bcb0] font-black uppercase text-[10px] hover:underline">Volver al Panel</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>