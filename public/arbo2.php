<?php
// fction qui gère l'indentation
function tab($index){
    $result = '';
    for($i=0; $i<$index; $i++) {
        $result .= '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
    }
    return $result;
}

// fction qui gère l'arborescence
function explorer($chemin='.', $name = 'At the beginning...', $tab=0){
    // affichage des dossiers
    echo tab($tab)."<img src='build/pictos/arrow_down.svg' alt='folder'><b> $name</b><br>";

    if(is_dir($chemin)) {
        $listeElements = opendir($chemin);
        asort($listeElements, 'type');
        $tab++;
        // bcle et selectionne les dossiers
        while ($element = readdir($listeElements)) {
            if ($element != '.' && $element != '..' && is_dir($chemin.DIRECTORY_SEPARATOR.$element)) {
                explorer($chemin . '/' . $element, $element, $tab);
            }
        }
        $listeElements = opendir($chemin);
        // bcle et selectionne les fichiers
        while ($element = readdir($listeElements)) {
            if (!is_dir($chemin.DIRECTORY_SEPARATOR.$element)) {
                // affichage des fichiers
                echo tab($tab)."<img src='build/pictos/arrow_roght.svg' alt='folder'> $element<br>";
            }
        }
    }
}

explorer();
