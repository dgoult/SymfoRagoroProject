<?php

namespace App\Helper;

use App\Entity\Intervenant;
use App\Entity\Matiere;
use App\Repository\IntervenantRepository;
use App\Repository\MatiereRepository;
use JetBrains\PhpStorm\ArrayShape;
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
                $heuresParIntervenant[] = $cour->getMatiere()->getIntitule() . ' - Le ' . $cour->getDateCours()->format('Y-m-d') . ' de ' . $cour->getHeureDebut()->format("H:i") . ' à ' . $cour->getHeureFin()->format("H:i")  ;
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
    #[ArrayShape(['minutes' => "int|null", 'couleur' => "string"])] #[Pure] public static function totalMinutesParIntervenant(Intervenant $intervenant): array
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

    public static function totalMinutesParMatiere(Matiere $matiere): ?int
    {
        $totalMinutes = 0;
        $cours = $matiere->getCours();
        foreach ($cours as $cour) {
            $totalMinutes += $cour->getDureeMinutes();
        }
        return $totalMinutes;
    }

    public static function totalMinutesMatieres(MatiereRepository $matiereRepository): ?int
    {
        $totalMinutes = 0;
        $matieres = $matiereRepository->findAll();

        foreach ($matieres as $matiere) {
            $cours = $matiere->getCours();
            foreach ($cours as $cour) {
                $totalMinutes += $cour->getDureeMinutes();
            }
        }
        return $totalMinutes;
    }

    /**
     * @param MatiereRepository $matiereRepository
     *
     * @return array
     */
    public static function heuresMatiere(MatiereRepository $matiereRepository): array
    {
        $heuresMatiere = [];
        $matieres = $matiereRepository->findAll();

        foreach ($matieres as $matiere) {
            $cours = $matiere->getCours();
            $heuresParMatiere = [];

            foreach ($cours as $cour) {
                $heuresParMatiere[] = $cour->getDateCours()->format('Y-m-d') . ' de ' . $cour->getHeureDebut()->format("H:i") . ' à ' . $cour->getHeureFin()->format("H:i")  ;
            }
            $heuresMatiere[$matiere->getIntitule()] = $heuresParMatiere;
        }
        return $heuresMatiere;
    }

    public static function statsMatiere(MatiereRepository $matiereRepository) {
        $matieres = $matiereRepository->findAll();
        $statsMatieres = ['Total : ' => self::totalMinutesMatieres($matiereRepository)];
        foreach ($matieres as $matiere) {

            $statsMatieres[$matiere->getIntitule()] = self::totalMinutesParMatiere($matiere);
        }
        return $statsMatieres;
    }

}