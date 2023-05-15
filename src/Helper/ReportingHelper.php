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
            $coursByIntervenant = ['Total : ' => self::totalMinutesParIntervenant($intervenant)];
            foreach ($cours as $cour) {
                $intituleMatiere = $cour->getMatiere()->getIntitule();

                if (!array_key_exists($intituleMatiere, $coursByIntervenant)) {
                    $coursByIntervenant[$intituleMatiere] = [
                        'minutes' => $cour->getDureeMinutes(),
                        'couleur' => $cour->getMatiere()->getCouleurCalendrier()
                    ];
                } else {
                    $coursByIntervenant[$intituleMatiere] = [
                        'minutes' => $coursByIntervenant[$intituleMatiere]['minutes'] + $cour->getDureeMinutes(),
                        'couleur' => $cour->getMatiere()->getCouleurCalendrier()
                    ];
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
    #[Pure] public static function totalMinutesParIntervenant(Intervenant $intervenant): array
    {
        // En Minutes
        $totalMinutes = 0;
        $cours = $intervenant->getCours();
        foreach ($cours as $cour) {
            $totalMinutes += $cour->getDureeMinutes();
        }
        return [
            'minutes' => $totalMinutes,
            'couleur' => "#000000"
        ];
    }

}