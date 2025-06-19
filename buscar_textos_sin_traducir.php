<?php
$directorio = __DIR__;
$extensiones = ['html'];
$carpetaLang = __DIR__ . '/lang';
$idiomas = ['es', 'en', 'ca'];
$patron_texto = '/>([^<>\?\=\n]{2,})</'; // texto entre etiquetas HTML

function escanearArchivos($dir, $extensiones) {
    $archivos = [];
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $ext = pathinfo($file->getFilename(), PATHINFO_EXTENSION);
            if (in_array($ext, $extensiones)) {
                $archivos[] = $file->getPathname();
            }
        }
    }

    return $archivos;
}

function buscarTextos($archivo) {
    global $patron_texto;

    $contenido = file_get_contents($archivo);
    preg_match_all($patron_texto, $contenido, $coincidencias);

    $resultados = [];

    foreach ($coincidencias[1] as $texto) {
        $textoLimpio = trim($texto);
        if (
            $textoLimpio !== '' &&
            !preg_match('/<\?= ?t\(.*\)/', $textoLimpio) &&
            substr($textoLimpio, 0, 3) !== '<?='
        ) {
            $resultados[] = $textoLimpio;
        }
    }

    return array_unique($resultados);
}

function generarClave($texto) {
    $clave = strtolower(trim($texto));
    $clave = preg_replace('/[^a-z0-9áéíóúüñ ]/iu', '', $clave);
    $clave = str_replace(['á','é','í','ó','ú','ü','ñ'], ['a','e','i','o','u','u','n'], $clave);
    $clave = preg_replace('/\s+/', '_', $clave);
    return substr($clave, 0, 50);
}

function crearArchivoIdioma($idioma, $diccionario, $carpetaLang) {
    $ruta = "$carpetaLang/$idioma.php";
    $contenido = "<?php\nreturn [\n";

    foreach ($diccionario as $clave => $valor) {
        $valorFinal = ($idioma === 'es') ? addslashes($valor) : '';
        $contenido .= "    '$clave' => '$valorFinal',\n";
    }

    $contenido .= "];\n";
    file_put_contents($ruta, $contenido);
    echo "✅ Archivo generado: lang/$idioma.php\n";
}

// Escanear
$archivos = escanearArchivos($directorio, $extensiones);
$diccionario = [];

echo "🔍 Textos visibles encontrados en archivos .html:\n\n";

foreach ($archivos as $archivo) {
    $textos = buscarTextos($archivo);
    if (!empty($textos)) {
        echo "📄 En archivo: $archivo\n";
        foreach ($textos as $texto) {
            $clave = generarClave($texto);
            echo "   → \"$texto\" → clave: \"$clave\"\n";
            $diccionario[$clave] = $texto;
        }
        echo "\n";
    }
}

// Crear carpeta lang si no existe
if (!is_dir($carpetaLang)) {
    mkdir($carpetaLang, 0755, true);
}

// Generar archivos por idioma
foreach ($idiomas as $idioma) {
    crearArchivoIdioma($idioma, $diccionario, $carpetaLang);
}

echo "\n🎯 Puedes traducir los archivos lang/en.php y lang/ca.php según corresponda.\n";
