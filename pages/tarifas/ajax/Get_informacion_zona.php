<?php
// Mostrar errores en desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('../../../class/Cls_tarifas.php');
$Cls_tarifas = new Cls_tarifas();

// Obtener la zona buscada (por POST o GET)
$zona = isset($_REQUEST['zona']) ? trim((string)$_REQUEST['zona']) : '';

if ($zona === '') {
    die('No se recibió el parámetro "zona".');
}

// Consultar datos
// $result = $Cls_tarifas->Get_rango_de_tarifas_por($zona);
// $num_filas = $result ? mysqli_num_rows($result) : 0;

// Obtener información de la zona
$resultado = $Cls_tarifas->obtenerPorId($zona);

if (!$resultado) {
    die('No se encontró información para la zona indicada.');
}
?>
<style>
#contenedor_img {
    width: 100%;
}

#bg_zona {
    filter: brightness(0.5);
    max-width: 100%;
    height: 19em;
    display: block;
}
</style>

<div class="relative w-full max-w-sm rounded-xl overflow-hidden shadow-lg">
    <!-- Imagen de fondo -->
    <div id="contenedor_img" class="absolute inset-0">
        <img 
            id="bg_zona"
            src="../assets/img/zonas/<?= htmlspecialchars($resultado['imagen']) ?>"
            alt="<?= htmlspecialchars($resultado['id']) ?>"
            class="w-full h-full object-cover"
        >
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
    </div>

    <!-- Contenido encima de la imagen -->
    <div class="relative p-4 text-white">
        <div class="border-black/12.5 rounded-t-2xl text-center pt-0 pb-6 lg:pt-2 lg:pb-4 p-t-20">
            <div class="flex justify-between">
                <button type="button" class="hidden px-8 py-2 font-bold text-white bg-cyan-500 rounded-lg shadow-md text-xs lg:block hover:shadow-xs hover:-translate-y-px active:opacity-85">Connect</button>
                <button type="button" class="block px-8 py-2 font-bold text-white bg-cyan-500 rounded-lg shadow-md text-xs lg:hidden hover:shadow-xs hover:-translate-y-px active:opacity-85">
                    <i class="ni ni-collection text-2.8"></i>
                </button>
                <button type="button" class="hidden px-8 py-2 font-bold text-white bg-slate-700 rounded-lg shadow-md text-xs lg:block hover:shadow-xs hover:-translate-y-px active:opacity-85">Message</button>
                <button type="button" class="block px-8 py-2 font-bold text-white bg-slate-700 rounded-lg shadow-md text-xs lg:hidden hover:shadow-xs hover:-translate-y-px active:opacity-85">
                    <i class="ni ni-email-83 text-2.8"></i>
                </button>
            </div>
        </div>

        <div class="mt-6 text-center">
            <div class="mb-2 font-semibold leading-relaxed text-base dark:text-white/80">
                <i class="mr-2 dark:text-white ni ni-pin-3"></i>
                <?= htmlspecialchars($resultado['id']) ?>
            </div>

            <div class="dark:text-white/80">
                <i class="mr-2 dark:text-white ni ni-hat-3"></i>
                <?= htmlspecialchars($resultado['direccion']) ?>
            </div>

            <div class="dark:text-white/80">
                <p class="flex items-center">
                    <?= htmlspecialchars($resultado['calificacion']) ?>
                </p>
            </div>
        </div>
    </div>
</div>


