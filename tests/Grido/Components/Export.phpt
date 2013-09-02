<?php

/**
 * Test: Export's component.
 *
 * @author     Petr Bugyík
 * @package    Grido\Tests
 */

require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../Helper.inc';

use Tester\Assert,
    Grido\Grid,
    Grido\Components\Export;

class ExportTest extends Tester\TestCase
{
    function testHasExport()
    {
        $grid = new Grid;
        Assert::false($grid->hasExport());

        $grid->setExport();
        Assert::false($grid->hasExport());
        Assert::true($grid->hasExport(FALSE));
    }

    function testSetExport()
    {
        $grid = new Grid;
        $label = 'export';

        $grid->setExport($label);
        $component = $grid->getExport();
        Assert::type('\Grido\Components\Export', $component);
        Assert::same($label, $component->label);

        Helper::grid(function(Grid $grid) {
            $grid->setExport();
            $component = $grid->getExport();
            Assert::same('Grid', $component->label);
        });
        Helper::request();

        unset($grid[Export::ID]);
        // getter
        Assert::exception(function() use ($grid) {
            $grid->getExport();
        }, 'InvalidArgumentException');

        Assert::null($grid->getExport(FALSE));
        Assert::error(function() use ($grid, $label) {
            $grid->setExporting($label);
        }, E_USER_DEPRECATED);
    }
}

run(__FILE__);