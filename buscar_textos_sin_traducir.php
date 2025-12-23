<?php

$directorio = __DIR__;
$extensiones = ['html'];
$carpetaLang = __DIR__ . '/lang';
$idiomas = ['es', 'en', 'ca'];

$patron_texto = '/>([^<>\?\=\n]{2,})</';

function escanearArchivos($dir, $extensiones)
{
    $archivos = [];
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            if (in_array(pathinfo($file->getFilename(), PATHINFO_EXTENSION), $extensiones)) {
                $archivos[] = $file->getPathname();
            }
        }
    }
    return $archivos;
}

function buscarTextos($archivo)
{
    global $patron_texto;
    $contenido = file_get_contents($archivo);
    preg_match_all($patron_texto, $contenido, $coincidencias);

    $resultados = [];
    foreach ($coincidencias[1] as $texto) {
        $texto = trim($texto);
        if ($texto !== '' && substr($texto, 0, 3) !== '<?=') {
            $resultados[] = $texto;
        }
    }
    return array_unique($resultados);
}

function generarClave($texto)
{
    $clave = strtolower(trim($texto));
    $clave = preg_replace('/[^a-z0-9áéíóúüñ ]/iu', '', $clave);
    $clave = str_replace(
        ['á','é','í','ó','ú','ü','ñ'],
        ['a','e','i','o','u','u','n'],
        $clave
    );
    return preg_replace('/\s+/', '_', $clave);
}

function crearArchivosPorIdioma($idioma, $data, $carpetaLang)
{
    $ruta = "$carpetaLang/$idioma.php";
    $contenido = "<?php\nreturn [\n";

    foreach ($data as $archivo => $textos) {
        $contenido .= "    '$archivo' => [\n";
        foreach ($textos as $clave => $valor) {
            $valorFinal = ($idioma === 'es') ? addslashes($valor) : '';
            $contenido .= "        '$clave' => '$valorFinal',\n";
        }
        $contenido .= "    ],\n\n";
    }

    $contenido .= "];\n";
    file_put_contents($ruta, $contenido);
    echo "✅ lang/$idioma.php generado\n";
}

/* ======================
   PROCESO
====================== */

$archivos = escanearArchivos($directorio, $extensiones);
$data = [];

foreach ($archivos as $archivo) {
    $nombreArchivo = pathinfo($archivo, PATHINFO_FILENAME);
    $textos = buscarTextos($archivo);

    foreach ($textos as $texto) {
        $clave = generarClave($texto);
        $data[$nombreArchivo][$clave] = $texto;
    }
}

if (!is_dir($carpetaLang)) {
    mkdir($carpetaLang, 0755, true);
}

foreach ($idiomas as $idioma) {
    crearArchivosPorIdioma($idioma, $data, $carpetaLang);
}

echo "\n🎯 Listo: arrays por archivo HTML y por idioma\n";
