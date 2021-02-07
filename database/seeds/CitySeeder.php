<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $city = [
            ['name' => 'Maroa'],
            ['name' => 'Puerto Ayacucho'],
            ['name' => 'San Fernando de Atabapo'],
            ['name' => 'Anaco'],
            ['name' => 'Aragua de Barcelona'],
            ['name' => 'Barcelona'],
            ['name' => 'Boca de Uchire'],
            ['name' => 'Cantaura'],
            ['name' => 'Clarines'],
            ['name' => 'El Chaparro'],
            ['name' => 'El Pao Anzoátegui'],
            ['name' => 'El Tigre'],
            ['name' => 'El Tigrito'],
            ['name' => 'Guanape'],
            ['name' => 'Guanta'],
            ['name' => 'Lechería'],
            ['name' => 'Onoto'],
            ['name' => 'Pariaguán'],
            ['name' => 'Píritu'],
            ['name' => 'Puerto La Cruz'],
            ['name' => 'Puerto Píritu'],
            ['name' => 'Sabana de Uchire'],
            ['name' => 'San Mateo Anzoátegui'],
            ['name' => 'San Pablo Anzoátegui'],
            ['name' => 'San Tomé'],
            ['name' => 'Santa Ana de Anzoátegui'],
            ['name' => 'Santa Fe Anzoátegui'],
            ['name' => 'Santa Rosa'],
            ['name' => 'Soledad'],
            ['name' => 'Urica'],
            ['name' => 'Valle de Guanape'],
            ['name' => 'Achaguas'],
            ['name' => 'Biruaca'],
            ['name' => 'Bruzual'],
            ['name' => 'El Amparo'],
            ['name' => 'El Nula'],
            ['name' => 'Elorza'],
            ['name' => 'Guasdualito'],
            ['name' => 'Mantecal'],
            ['name' => 'Puerto Páez'],
            ['name' => 'San Fernando de Apure'],
            ['name' => 'San Juan de Payara'],
            ['name' => 'Barbacoas'],
            ['name' => 'Cagua'],
            ['name' => 'Camatagua'],
            ['name' => 'Choroní'],
            ['name' => 'Colonia Tovar'],
            ['name' => 'El Consejo'],
            ['name' => 'La Victoria'],
            ['name' => 'Las Tejerías'],
            ['name' => 'Magdaleno'],
            ['name' => 'Maracay'],
            ['name' => 'Ocumare de La Costa'],
            ['name' => 'Palo Negro'],
            ['name' => 'San Casimiro'],
            ['name' => 'San Mateo'],
            ['name' => 'San Sebastián'],
            ['name' => 'Santa Cruz de Aragua'],
            ['name' => 'Tocorón'],
            ['name' => 'Turmero'],
            ['name' => 'Villa de Cura'],
            ['name' => 'Zuata'],
            ['name' => 'Barinas'],
            ['name' => 'Barinitas'],
            ['name' => 'Barrancas'],
            ['name' => 'Calderas'],
            ['name' => 'Capitanejo'],
            ['name' => 'Ciudad Bolivia'],
            ['name' => 'El Cantón'],
            ['name' => 'Las Veguitas'],
            ['name' => 'Libertad de Barinas'],
            ['name' => 'Sabaneta'],
            ['name' => 'Santa Bárbara de Barinas'],
            ['name' => 'Socopó'],
            ['name' => 'Caicara del Orinoco'],
            ['name' => 'Canaima'],
            ['name' => 'Ciudad Bolívar'],
            ['name' => 'Ciudad Piar'],
            ['name' => 'El Callao'],
            ['name' => 'El Dorado'],
            ['name' => 'El Manteco'],
            ['name' => 'El Palmar'],
            ['name' => 'El Pao'],
            ['name' => 'Guasipati'],
            ['name' => 'Guri'],
            ['name' => 'La Paragua'],
            ['name' => 'Matanzas'],
            ['name' => 'Puerto Ordaz'],
            ['name' => 'San Félix'],
            ['name' => 'Santa Elena de Uairén'],
            ['name' => 'Tumeremo'],
            ['name' => 'Unare'],
            ['name' => 'Upata'],
            ['name' => 'Bejuma'],
            ['name' => 'Belén'],
            ['name' => 'Campo de Carabobo'],
            ['name' => 'Canoabo'],
            ['name' => 'Central Tacarigua'],
            ['name' => 'Chirgua'],
            ['name' => 'Ciudad Alianza'],
            ['name' => 'El Palito'],
            ['name' => 'Guacara'],
            ['name' => 'Guigue'],
            ['name' => 'Las Trincheras'],
            ['name' => 'Los Guayos'],
            ['name' => 'Mariara'],
            ['name' => 'Miranda'],
            ['name' => 'Montalbán'],
            ['name' => 'Morón'],
            ['name' => 'Naguanagua'],
            ['name' => 'Puerto Cabello'],
            ['name' => 'San Joaquín'],
            ['name' => 'Tocuyito'],
            ['name' => 'Urama'],
            ['name' => 'Valencia'],
            ['name' => 'Vigirimita'],
            ['name' => 'Aguirre'],
            ['name' => 'Apartaderos Cojedes'],
            ['name' => 'Arismendi'],
            ['name' => 'Camuriquito'],
            ['name' => 'El Baúl'],
            ['name' => 'El Limón'],
            ['name' => 'El Pao Cojedes'],
            ['name' => 'El Socorro'],
            ['name' => 'La Aguadita'],
            ['name' => 'Las Vegas'],
            ['name' => 'Libertad de Cojedes'],
            ['name' => 'Mapuey'],
            ['name' => 'Piñedo'],
            ['name' => 'Samancito'],
            ['name' => 'San Carlos'],
            ['name' => 'Sucre'],
            ['name' => 'Tinaco'],
            ['name' => 'Tinaquillo'],
            ['name' => 'Vallecito'],
            ['name' => 'Tucupita'],
            ['name' => 'Caracas'],
            ['name' => 'El Junquito'],
            ['name' => 'Adícora'],
            ['name' => 'Boca de Aroa'],
            ['name' => 'Cabure'],
            ['name' => 'Capadare'],
            ['name' => 'Capatárida'],
            ['name' => 'Chichiriviche'],
            ['name' => 'Churuguara'],
            ['name' => 'Coro'],
            ['name' => 'Cumarebo'],
            ['name' => 'Dabajuro'],
            ['name' => 'Judibana'],
            ['name' => 'La Cruz de Taratara'],
            ['name' => 'La Vela de Coro'],
            ['name' => 'Los Taques'],
            ['name' => 'Maparari'],
            ['name' => 'Mene de Mauroa'],
            ['name' => 'Mirimire'],
            ['name' => 'Pedregal'],
            ['name' => 'Píritu Falcón'],
            ['name' => 'Pueblo Nuevo Falcón'],
            ['name' => 'Puerto Cumarebo'],
            ['name' => 'Punta Cardón'],
            ['name' => 'Punto Fijo'],
            ['name' => 'San Juan de Los Cayos'],
            ['name' => 'San Luis'],
            ['name' => 'Santa Ana Falcón'],
            ['name' => 'Santa Cruz De Bucaral'],
            ['name' => 'Tocopero'],
            ['name' => 'Tocuyo de La Costa'],
            ['name' => 'Tucacas'],
            ['name' => 'Yaracal'],
            ['name' => 'Altagracia de Orituco'],
            ['name' => 'Cabruta'],
            ['name' => 'Calabozo'],
            ['name' => 'Camaguán'],
            ['name' => 'Chaguaramas Guárico'],
            ['name' => 'El Socorro'],
            ['name' => 'El Sombrero'],
            ['name' => 'Las Mercedes de Los Llanos'],
            ['name' => 'Lezama'],
            ['name' => 'Onoto'],
            ['name' => 'Ortíz'],
            ['name' => 'San José de Guaribe'],
            ['name' => 'San Juan de Los Morros'],
            ['name' => 'San Rafael de Laya'],
            ['name' => 'Santa María de Ipire'],
            ['name' => 'Tucupido'],
            ['name' => 'Valle de La Pascua'],
            ['name' => 'Zaraza'],
            ['name' => 'Aguada Grande'],
            ['name' => 'Atarigua'],
            ['name' => 'Barquisimeto'],
            ['name' => 'Bobare'],
            ['name' => 'Cabudare'],
            ['name' => 'Carora'],
            ['name' => 'Cubiro'],
            ['name' => 'Cují'],
            ['name' => 'Duaca'],
            ['name' => 'El Manzano'],
            ['name' => 'El Tocuyo'],
            ['name' => 'Guaríco'],
            ['name' => 'Humocaro Alto'],
            ['name' => 'Humocaro Bajo'],
            ['name' => 'La Miel'],
            ['name' => 'Moroturo'],
            ['name' => 'Quíbor'],
            ['name' => 'Río Claro'],
            ['name' => 'Sanare'],
            ['name' => 'Santa Inés'],
            ['name' => 'Sarare'],
            ['name' => 'Siquisique'],
            ['name' => 'Tintorero'],
            ['name' => 'Apartaderos Mérida'],
            ['name' => 'Arapuey'],
            ['name' => 'Bailadores'],
            ['name' => 'Caja Seca'],
            ['name' => 'Canaguá'],
            ['name' => 'Chachopo'],
            ['name' => 'Chiguara'],
            ['name' => 'Ejido'],
            ['name' => 'El Vigía'],
            ['name' => 'La Azulita'],
            ['name' => 'La Playa'],
            ['name' => 'Lagunillas Mérida'],
            ['name' => 'Mérida'],
            ['name' => 'Mesa de Bolívar'],
            ['name' => 'Mucuchíes'],
            ['name' => 'Mucujepe'],
            ['name' => 'Mucuruba'],
            ['name' => 'Nueva Bolivia'],
            ['name' => 'Palmarito'],
            ['name' => 'Pueblo Llano'],
            ['name' => 'Santa Cruz de Mora'],
            ['name' => 'Santa Elena de Arenales'],
            ['name' => 'Santo Domingo'],
            ['name' => 'Tabáy'],
            ['name' => 'Timotes'],
            ['name' => 'Torondoy'],
            ['name' => 'Tovar'],
            ['name' => 'Tucani'],
            ['name' => 'Zea'],
            ['name' => 'Araguita'],
            ['name' => 'Carrizal'],
            ['name' => 'Caucagua'],
            ['name' => 'Chaguaramas Miranda'],
            ['name' => 'Charallave'],
            ['name' => 'Chirimena'],
            ['name' => 'Chuspa'],
            ['name' => 'Cúa'],
            ['name' => 'Cupira'],
            ['name' => 'Curiepe'],
            ['name' => 'El Guapo'],
            ['name' => 'El Jarillo'],
            ['name' => 'Filas de Mariche'],
            ['name' => 'Guarenas'],
            ['name' => 'Guatire'],
            ['name' => 'Higuerote'],
            ['name' => 'Los Anaucos'],
            ['name' => 'Los Teques'],
            ['name' => 'Ocumare del Tuy'],
            ['name' => 'Panaquire'],
            ['name' => 'Paracotos'],
            ['name' => 'Río Chico'],
            ['name' => 'San Antonio de Los Altos'],
            ['name' => 'San Diego de Los Altos'],
            ['name' => 'San Fernando del Guapo'],
            ['name' => 'San Francisco de Yare'],
            ['name' => 'San José de Los Altos'],
            ['name' => 'San José de Río Chico'],
            ['name' => 'San Pedro de Los Altos'],
            ['name' => 'Santa Lucía'],
            ['name' => 'Santa Teresa'],
            ['name' => 'Tacarigua de La Laguna'],
            ['name' => 'Tacarigua de Mamporal'],
            ['name' => 'Tácata'],
            ['name' => 'Turumo'],
            ['name' => 'Aguasay'],
            ['name' => 'Aragua de Maturín'],
            ['name' => 'Barrancas del Orinoco'],
            ['name' => 'Caicara de Maturín'],
            ['name' => 'Caripe'],
            ['name' => 'Caripito'],
            ['name' => 'Chaguaramal'],
            ['name' => 'Chaguaramas Monagas'],
            ['name' => 'El Furrial'],
            ['name' => 'El Tejero'],
            ['name' => 'Jusepín'],
            ['name' => 'La Toscana'],
            ['name' => 'Maturín'],
            ['name' => 'Miraflores'],
            ['name' => 'Punta de Mata'],
            ['name' => 'Quiriquire'],
            ['name' => 'San Antonio de Maturín'],
            ['name' => 'San Vicente Monagas'],
            ['name' => 'Santa Bárbara'],
            ['name' => 'Temblador'],
            ['name' => 'Teresen'],
            ['name' => 'Uracoa'],
            ['name' => 'Altagracia'],
            ['name' => 'Boca de Pozo'],
            ['name' => 'Boca de Río'],
            ['name' => 'El Espinal'],
            ['name' => 'El Valle del Espíritu Santo'],
            ['name' => 'El Yaque'],
            ['name' => 'Juangriego'],
            ['name' => 'La Asunción'],
            ['name' => 'La Guardia'],
            ['name' => 'Pampatar'],
            ['name' => 'Porlamar'],
            ['name' => 'Puerto Fermín'],
            ['name' => 'Punta de Piedras'],
            ['name' => 'San Francisco de Macanao'],
            ['name' => 'San Juan Bautista'],
            ['name' => 'San Pedro de Coche'],
            ['name' => 'Santa Ana de Nueva Esparta'],
            ['name' => 'Villa Rosa'],
            ['name' => 'Acarigua'],
            ['name' => 'Agua Blanca'],
            ['name' => 'Araure'],
            ['name' => 'Biscucuy'],
            ['name' => 'Boconoito'],
            ['name' => 'Campo Elías'],
            ['name' => 'Chabasquén'],
            ['name' => 'Guanare'],
            ['name' => 'Guanarito'],
            ['name' => 'La Aparición'],
            ['name' => 'La Misión'],
            ['name' => 'Mesa de Cavacas'],
            ['name' => 'Ospino'],
            ['name' => 'Papelón'],
            ['name' => 'Payara'],
            ['name' => 'Pimpinela'],
            ['name' => 'Píritu de Portuguesa'],
            ['name' => 'San Rafael de Onoto'],
            ['name' => 'Santa Rosalía'],
            ['name' => 'Turén'],
            ['name' => 'Altos de Sucre'],
            ['name' => 'Araya'],
            ['name' => 'Cariaco'],
            ['name' => 'Carúpano'],
            ['name' => 'Casanay'],
            ['name' => 'Cumaná'],
            ['name' => 'Cumanacoa'],
            ['name' => 'El Morro Puerto Santo'],
            ['name' => 'El Pilar'],
            ['name' => 'El Poblado'],
            ['name' => 'Guaca'],
            ['name' => 'Guiria'],
            ['name' => 'Irapa'],
            ['name' => 'Manicuare'],
            ['name' => 'Mariguitar'],
            ['name' => 'Río Caribe'],
            ['name' => 'San Antonio del Golfo'],
            ['name' => 'San José de Aerocuar'],
            ['name' => 'San Vicente de Sucre'],
            ['name' => 'Santa Fe de Sucre'],
            ['name' => 'Tunapuy'],
            ['name' => 'Yaguaraparo'],
            ['name' => 'Yoco'],
            ['name' => 'Abejales'],
            ['name' => 'Borota'],
            ['name' => 'Bramon'],
            ['name' => 'Capacho'],
            ['name' => 'Colón'],
            ['name' => 'Coloncito'],
            ['name' => 'Cordero'],
            ['name' => 'El Cobre'],
            ['name' => 'El Pinal'],
            ['name' => 'Independencia'],
            ['name' => 'La Fría'],
            ['name' => 'La Grita'],
            ['name' => 'La Pedrera'],
            ['name' => 'La Tendida'],
            ['name' => 'Las Delicias'],
            ['name' => 'Las Hernández'],
            ['name' => 'Lobatera'],
            ['name' => 'Michelena'],
            ['name' => 'Palmira'],
            ['name' => 'Pregonero'],
            ['name' => 'Queniquea'],
            ['name' => 'Rubio'],
            ['name' => 'San Antonio del Tachira'],
            ['name' => 'San Cristobal'],
            ['name' => 'San José de Bolívar'],
            ['name' => 'San Josecito'],
            ['name' => 'San Pedro del Río'],
            ['name' => 'Santa Ana Táchira'],
            ['name' => 'Seboruco'],
            ['name' => 'Táriba'],
            ['name' => 'Umuquena'],
            ['name' => 'Ureña'],
            ['name' => 'Batatal'],
            ['name' => 'Betijoque'],
            ['name' => 'Boconó'],
            ['name' => 'Carache'],
            ['name' => 'Chejende'],
            ['name' => 'Cuicas'],
            ['name' => 'El Dividive'],
            ['name' => 'El Jaguito'],
            ['name' => 'Escuque'],
            ['name' => 'Isnotú'],
            ['name' => 'Jajó'],
            ['name' => 'La Ceiba'],
            ['name' => 'La Concepción de Trujllo'],
            ['name' => 'La Mesa de Esnujaque'],
            ['name' => 'La Puerta'],
            ['name' => 'La Quebrada'],
            ['name' => 'Mendoza Fría'],
            ['name' => 'Meseta de Chimpire'],
            ['name' => 'Monay'],
            ['name' => 'Motatán'],
            ['name' => 'Pampán'],
            ['name' => 'Pampanito'],
            ['name' => 'Sabana de Mendoza'],
            ['name' => 'San Lázaro'],
            ['name' => 'Santa Ana de Trujillo'],
            ['name' => 'Tostós'],
            ['name' => 'Trujillo'],
            ['name' => 'Valera'],
            ['name' => 'Carayaca'],
            ['name' => 'Litoral'],
            ['name' => 'Archipiélago Los Roques'],
            ['name' => 'Aroa'],
            ['name' => 'Boraure'],
            ['name' => 'Campo Elías de Yaracuy'],
            ['name' => 'Chivacoa'],
            ['name' => 'Cocorote'],
            ['name' => 'Farriar'],
            ['name' => 'Guama'],
            ['name' => 'Marín'],
            ['name' => 'Nirgua'],
            ['name' => 'Sabana de Parra'],
            ['name' => 'Salom'],
            ['name' => 'San Felipe'],
            ['name' => 'San Pablo de Yaracuy'],
            ['name' => 'Urachiche'],
            ['name' => 'Yaritagua'],
            ['name' => 'Yumare'],
            ['name' => 'Bachaquero'],
            ['name' => 'Bobures'],
            ['name' => 'Cabimas'],
            ['name' => 'Campo Concepción'],
            ['name' => 'Campo Mara'],
            ['name' => 'Campo Rojo'],
            ['name' => 'Carrasquero'],
            ['name' => 'Casigua'],
            ['name' => 'Chiquinquirá'],
            ['name' => 'Ciudad Ojeda'],
            ['name' => 'El Batey'],
            ['name' => 'El Carmelo'],
            ['name' => 'El Chivo'],
            ['name' => 'El Guayabo'],
            ['name' => 'El Mene'],
            ['name' => 'El Venado'],
            ['name' => 'Encontrados'],
            ['name' => 'Gibraltar'],
            ['name' => 'Isla de Toas'],
            ['name' => 'La Concepción del Zulia'],
            ['name' => 'La Paz'],
            ['name' => 'La Sierrita'],
            ['name' => 'Lagunillas del Zulia'],
            ['name' => 'Las Piedras de Perijá'],
            ['name' => 'Los Cortijos'],
            ['name' => 'Machiques'],
            ['name' => 'Maracaibo'],
            ['name' => 'Mene Grande'],
            ['name' => 'Palmarejo'],
            ['name' => 'Paraguaipoa'],
            ['name' => 'Potrerito'],
            ['name' => 'Pueblo Nuevo del Zulia'],
            ['name' => 'Puertos de Altagracia'],
            ['name' => 'Punta Gorda'],
            ['name' => 'Sabaneta de Palma'],
            ['name' => 'San Francisco'],
            ['name' => 'San José de Perijá'],
            ['name' => 'San Rafael del Moján'],
            ['name' => 'San Timoteo'],
            ['name' => 'Santa Bárbara Del Zulia'],
            ['name' => 'Santa Cruz de Mara'],
            ['name' => 'Santa Cruz del Zulia'],
            ['name' => 'Santa Rita'],
            ['name' => 'Sinamaica'],
            ['name' => 'Tamare'],
            ['name' => 'Tía Juana'],
            ['name' => 'Villa del Rosario'],
            ['name' => 'La Guaira'],
            ['name' => 'Catia La Mar'],
            ['name' => 'Macuto'],
            ['name' => 'Naiguatá'],
            ['name' => 'Archipiélago Los Monjes'],
            ['name' => 'Isla La Tortuga y Cayos adyacentes'],
            ['name' => 'Isla La Sola'],
            ['name' => 'Islas Los Testigos'],
            ['name' => 'Islas Los Frailes'],
            ['name' => 'Isla La Orchila'],
            ['name' => 'Archipiélago Las Aves'],
            ['name' => 'Isla de Aves'],
            ['name' => 'Isla La Blanquilla'],
            ['name' => 'Isla de Patos'],
            ['name' => 'Islas Los Hermanos'],
            ['name' => 'Miami'],
        ];
        
        DB::table('cities')->insert($city);
    }
}
