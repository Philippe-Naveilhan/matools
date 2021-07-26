<?php

namespace App\Service;

use App\Repository\CompetencestudentRepository;

class Completion extends CompetencestudentRepository
{
    public function completion($evalcompetence):string
    {
        $nbempty = count($this->findByEmpty($evalcompetence));
        $nbTotal = $this->countAll($evalcompetence);

        if ($nbempty == 0) {
            return 'full';
        }
        elseif ($nbempty == $nbTotal) {
            return 'empty';
        }
        elseif ($nbempty < $nbTotal){
            return 'partiel';
        }
        else {
            return 'error';
        }
    }
}
