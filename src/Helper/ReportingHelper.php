<?php

namespace App\Helper;

use App\Repository\IntervenantRepository;

class ReportingHelper
{

    /**
     * @param IntervenantRepository $intervenantRepository
     *
     * @return array
     */
    public static function statsIntervenant(IntervenantRepository $intervenantRepository): array
    {
        $intervenantReportingArray = [];
        $intervenants = $intervenantRepository->findAll();

        foreach ($intervenants as $intervenant) {
            $cours = $intervenant->getCours();
            $coursByIntervenant = [];

            foreach ($cours as $cour) {
                if (array_key_exists($cour->getMatiere()->getIntitule(), $coursByIntervenant)) {
                    $coursByIntervenant[$cour->getMatiere()->getIntitule()] += $cour->getDureeHeures();
                } else {
                    $coursByIntervenant[$cour->getMatiere()->getIntitule()] = $cour->getDureeHeures();
                }
            }
            $intervenantReportingArray[$intervenant->getFullName()] = $coursByIntervenant;
        }
        return $intervenantReportingArray;
    }

}