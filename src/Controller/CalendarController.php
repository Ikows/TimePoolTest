<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{
    /**
     * @Route("/calendar", name="calendar")
     */
    public function index()
    {
        $month = new \App\Service\Month($_GET['month'] ?? null, $_GET['year'] ?? null) ;
        $startingDay = $month->getStartingDay();
        $startingDay = $startingDay->format("N") == 1 ? $startingDay : $startingDay->modify('last monday');

        return $this->render('calendar/index.html.twig', [
            'month' => $month,
            'startingDay' => $startingDay
        ]);
    }
}
