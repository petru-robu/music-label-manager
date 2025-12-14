<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/Analytics.php';

class AnalyticsController extends Controller
{
    private Analytics $analyticsModel;

    public function __construct()
    {
        $this->analyticsModel = new Analytics();
    }

    public function index()
    {
        // returns the index analytics view

        $totals = Analytics::getTotals();
        $viewsPerDay = Analytics::getViewsPerDay();
        $topPages = Analytics::getTopPages();

        $this->render('Analytics/index', [
            'totals'      => $totals,
            'viewsPerDay' => $viewsPerDay,
            'topPages'    => $topPages,
        ]);
    }

    public function purgeOld($days = 90)
    {
        // delete old entries
        $deleted = Analytics::purgeOlderThan((int)$days);
        echo "Deleted $deleted old analytics records from $days days ago.";
    }
}
