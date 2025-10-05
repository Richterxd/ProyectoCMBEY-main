<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reunion;
use App\Models\Solicitud;
use App\Models\Institucion;
use App\Models\Personas;
use Carbon\Carbon;

class ReunionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verify required data exists
        $solicitudes = Solicitud::all();
        $instituciones = Institucion::all();
        $personas = Personas::all();

        if ($solicitudes->isEmpty() || $instituciones->isEmpty() || $personas->isEmpty()) {
            $this->command->warn('No hay suficientes datos base (solicitudes, instituciones, personas) para crear reuniones de prueba.');
            return;
        }

        $reunionesData = [
            [
                'titulo' => 'Revisión de Proyecto de Agua Potable',
                'descripcion' => 'Reunión para evaluar el avance del proyecto de mejoramiento del sistema de agua potable en la comunidad Las Flores. Se discutirán los aspectos técnicos, presupuestarios y cronograma de ejecución.',
                'fecha_reunion' => Carbon::now()->addDays(7)->setTime(9, 0),
                'ubicacion' => 'Sala de Reuniones CMBEY - Piso 2',
            ],
            [
                'titulo' => 'Seguimiento a Solicitud de Alumbrado Público',
                'descripcion' => 'Evaluación del estado actual de la solicitud de reparación del alumbrado público en el sector Centro. Revisión de presupuesto y asignación de recursos.',
                'fecha_reunion' => Carbon::now()->addDays(10)->setTime(14, 30),
                'ubicacion' => 'Oficina de Planificación Municipal',
            ],
            [
                'titulo' => 'Mesa de Trabajo Educación Primaria',
                'descripcion' => 'Reunión de coordinación para atender las solicitudes relacionadas con infraestructura educativa en las escuelas primarias del municipio. Participación de directores y representantes.',
                'fecha_reunion' => Carbon::now()->addDays(14)->setTime(10, 0),
                'ubicacion' => 'Auditorio Municipal',
            ],
            [
                'titulo' => 'Evaluación de Emergencias Naturales',
                'descripcion' => 'Sesión de trabajo para revisar los protocolos de atención ante eventos naturales adversos y evaluar las solicitudes de asistencia recibidas.',
                'fecha_reunion' => Carbon::now()->subDays(3)->setTime(16, 0),
                'ubicacion' => 'Centro de Operaciones de Emergencia',
            ],
            [
                'titulo' => 'Reunión de Seguimiento Servicios Públicos',
                'descripcion' => 'Evaluación integral del estado de los servicios públicos municipales y revisión de las solicitudes pendientes de atención.',
                'fecha_reunion' => Carbon::now()->subDays(7)->setTime(8, 30),
                'ubicacion' => 'Sala Principal CMBEY',
            ]
        ];

        foreach ($reunionesData as $index => $reunionData) {
            // Assign random solicitud and institucion
            $solicitud = $solicitudes->random();
            $institucion = $instituciones->random();

            $reunion = Reunion::create([
                'solicitud_id' => $solicitud->id,
                'institucion_id' => $institucion->id,
                'titulo' => $reunionData['titulo'],
                'descripcion' => $reunionData['descripcion'],
                'fecha_reunion' => $reunionData['fecha_reunion'],
                'ubicacion' => $reunionData['ubicacion'],
            ]);

            // Assign random asistentes (2-5 personas)
            $numAsistentes = rand(2, min(5, $personas->count()));
            $asistentesSeleccionados = $personas->random($numAsistentes);
            
            // Select one random attendee as Concejal
            $concejalCedula = $asistentesSeleccionados->random()->cedula;
            
            $asistentesData = [];
            foreach ($asistentesSeleccionados as $asistente) {
                $asistentesData[$asistente->cedula] = [
                    'es_concejal' => ($asistente->cedula === $concejalCedula)
                ];
            }
            
            $reunion->asistentes()->sync($asistentesData);

            $this->command->info("Reunión creada: {$reunion->titulo} con {$numAsistentes} asistentes");
        }

        $this->command->info('Seeder de Reuniones completado exitosamente.');
    }
}