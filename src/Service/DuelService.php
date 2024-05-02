<?php

namespace App\Service;

class DuelService
{
    public function calculerCote($noteCombattant1, $noteCombattant2)
    {
        $probabilite1 = $noteCombattant1 / ($noteCombattant1 + $noteCombattant2);
        $probabilite2 = $noteCombattant2 / ($noteCombattant1 + $noteCombattant2);

        if ($noteCombattant1 == $noteCombattant2) {
            $probabilite1 = 0.5;
            $probabilite2 = 0.5;
        }

        $cote1 = round(1 / $probabilite1, 2);
        $cote2 = round(1 / $probabilite2, 2);

        return [$cote1, $cote2];
    }

    public function returnProba($noteCombattant1, $noteCombattant2)
    {
        $probabilite1 = $noteCombattant1 / ($noteCombattant1 + $noteCombattant2);
        $probabilite2 = $noteCombattant2 / ($noteCombattant1 + $noteCombattant2);

        if ($noteCombattant1 == $noteCombattant2) {
            $probabilite1 = 0.5;
            $probabilite2 = 0.5;
        }

        return [$probabilite1, $probabilite2];
    }

    public function simulationFight($proba1, $fighter1Id, $fighter2Id)
    {
        $rand = mt_rand() / mt_getrandmax();

        if ($rand <= $proba1) {
            return $fighter1Id;
        } else {
            return $fighter2Id;
        }
    }
}
