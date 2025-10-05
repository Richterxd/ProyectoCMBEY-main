<?php

namespace Database\Seeders;

use App\Models\Sectores;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectores = [
            ['sector' => 'OTRO...', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'POZO NUEVO', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'SAN ANTONIO', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'LA PEÑITA', 'parroquia' => 'CHIVACOA'],
            ['sector' => '19 DE ABRIL', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'TRICENTENARIO', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'ALI PRIMERA Y ENMANUEL VIVE', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'RIVERAS DE CUMARIPA', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'MONTE OSCURO', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'LOS BOLIVARIANOS', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'LA LUCHA', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'EL ESTADIUM', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'JOSE FELIX RIBAS II', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'WILLIAN LARA', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'NUEVA ESPERANZA', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'ANDRES BELLO', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'MONSEÑOR VICENTE LAMBRUCHINI', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'EZEQUIEL ZAMORA', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'PEGUAIMA', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'SAN ANTONIO DE PEGUAIMA', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'GUATANQUIRE I', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'GUATANQUIRE II', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'BARRIO CENTRO', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'POZO NUEVO', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'VILLA LA INDEPENDENCIA', 'parroquia' => 'CHIVACOA'],
            ['sector' => '23 DE ENERO 1 Y 2', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'VILLA ZAZARIVACOA SECTOR LA LIBERTAD', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'CAÑAVERAL', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'PALO VERDE ', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'LA LIBERTAD', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'LA CANDELARIA II', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'ASENTAMIENTO CAMPESINO EL BARREDEÑO', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'AGRARIO SANTA MARIA EL POZON', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'BRISAS DEL SUR', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'FELIPERO EL PEREÑO', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'SAN JOSE', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'JOSE FELIX RIBAS I', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'DANIEL CARIAS LIMA', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'PUEBLO NUEVO', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'BICENTENARIO', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'BANCO OBRERO', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'GUAICAIPURO', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'TAMARINDO II', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'MARIA LIONZA I', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'CENTRO EL CEIBAL', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'SANTA LUCIA', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'VALLE VERDE', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'SANTA CATALINA', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'AGRICOLA CHUPONAL', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'AGRARIO SAN JUAN', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'DON JUAN CANEPE', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'AGRARIO LAS PALMERAS', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'SAN JOSE DE BUCHICABURE', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'INDIO MACHO', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'LAS MULITAS Y EL TIAMAL', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'LOS HORCONES', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'EL CALICHE', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'SAN ANDRES FUNDO CUMARIPA', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'SARARE', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'LAS DELICIAS', 'parroquia' => 'CHIVACOA'],
            ['sector' => 'CUMARIPA', 'parroquia' => 'CHIVACOA'],

            
            ['sector' => 'OTRO...', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'EL COPEY', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'SAN IGNACIO', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'CENTRO LA VIRGEN', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'COCUAIMA', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'LAS PALMAS', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'LOS NARANJILLOS', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'ALTO RIO ', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'LA CAÑADA Y CARACARO', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'SAN RAMON', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'VILLA LOS VENCEDORES', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'SANTA CRUZ', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'LA VILLA EL JULIANERO SECTOR I', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'LA NEBLINA', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'ALDEA SANTA ROSA', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'SANTA ELENA', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'EL NARANJAL', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'SANTA CATALINA DE ALEJANDRIA', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'CAJA DE AGUA-ACEITUNO', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'LOS CHAMIZOS', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'LA MANGA', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'MORROCOYAL', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'SAMAN LA CARRETERA', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'TETEIBA', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'SABANA DE LA HORCA', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'BELLA VISTA', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'LOS VENCEDORES', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'POA POA', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'PALO GRANDE', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'LA GRILLERA', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'LA BARTOLA', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'LOS COLORADOS', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'LOS COLORADOS PARTE BAJA NUEVA ESPERANZA', 'parroquia' => 'CAMPO_ELIAS'],
            ['sector' => 'SABANA LARGA', 'parroquia' => 'CAMPO_ELIAS'],
        ];

        foreach ($sectores as $sector) {
            Sectores::updateOrCreate(
                ['sector' => $sector['sector']],
                $sector);
            
        }

    }
}
