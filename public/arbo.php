<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://i.icomoon.io/public/temp/ccec4752df/UntitledProject/style-svg.css">
    <script defer src="https://i.icomoon.io/public/temp/ccec4752df/UntitledProject/svgxuse.js"></script>
    <title>Document</title>
    <style>
        .folder {
            padding: .5rem;
            margin: 1rem;
            border-left: 1px solid gray;
        }

        .icon {
            display: inline-block;
            width: 3em;
            height: 3em;
            stroke-width: 0;
            stroke: black;
            fill: black;
        }
    </style>
</head>
<body>

<h1>Hello</h1>
<?php

/**
 * fonction générant l'arborescence
 * @param $dir
 * @return array
 */
function dirToArray($dir): array
{
    $result = [];
    $cdir = scandir($dir);
    foreach ($cdir as $key => $value) {
        if (!in_array($value, [".", ".."])) {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                // on ouvre la balise container
                echo "<div class='folder'>";
                // on affiche l'icon du dossier
                echo iconFolder($value);

                $result[] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
                // on ferme la balise container
                echo "</div>";

            } else {
                // on affiche le contenu du dossier
                echo "<p>" . $value . "</p>";
                $result[] = $value;
            }
        }
    }
    return $result;
}

/**
 * renvoi l'icone folder
 * @param string $value
 * @return string
 */
function iconFolder(string $value): string
{
    $svg = "<div class='clearfix mhl ptl'>";
    $svg .= "<div class='glyph fs1'>";
    $svg .= "<div class='clearfix pbs'>";
    $svg .= "<svg class='icon icon-folder'>";
    $svg .= "<use xlink:href='#icon-folder'></use>";
    $svg .= "</svg>";
    $svg .= "</div>";
    $svg .= "</div>";
    $svg .= "</div>";
    $svg .= "<p>" . $value . "</p>";
    return $svg;
}

// appel de la fonction d'affichage de l'arborescence en mentionnant le repertoire. NE PAS METTRE DE "/" A LA FIN
dirToArray(".");
?>
</body>
</html>
