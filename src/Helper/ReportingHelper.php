<?php

namespace App\Helper;

use App\Entity\Intervenant;
use App\Repository\IntervenantRepository;
use JetBrains\PhpStorm\Pure;

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
            $coursByIntervenant = ['Total : ' . PHP_EOL => self::totalHeuresParIntervenant($intervenant)];
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

    /**
     * @param IntervenantRepository $intervenantRepository
     *
     * @return array
     */
    public static function heuresIntervenant(IntervenantRepository $intervenantRepository): array
    {
        $heuresIntervenant = [];
        $intervenants = $intervenantRepository->findAll();

        foreach ($intervenants as $intervenant) {
            $cours = $intervenant->getCours();
            $heuresParIntervenant = [];

            foreach ($cours as $cour) {
                $heuresParIntervenant[] = $cour->getDateCours()->format('Y-m-d') . ' de ' . $cour->getHeureDebut()->format("H:i") . ' à ' . $cour->getHeureFin()->format("H:i")  ;
            }
            $heuresIntervenant[$intervenant->getFullName()] = $heuresParIntervenant;
        }
        return $heuresIntervenant;
    }

    /**
     * @param Intervenant $intervenant
     *
     * @return array
     */
    #[Pure] public static function totalHeuresParIntervenant(Intervenant $intervenant): array
    {
        // En Minutes
        $totalHeures = 0;
        $cours = $intervenant->getCours();
        foreach ($cours as $cour) {
            $totalHeures += $cour->getDureeMinutes();
        }
        return [
            'h' => floor($totalHeures / 60),
            'm' => $totalHeures % 60,
            'couleur' => "#000000"
        ];
    }

}