<?php
namespace AOE\HappyFeet\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 AOE GmbH <dev@aoe.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use AOE\HappyFeet\Domain\Model\Footnote;
use Nimut\TestingFramework\TestCase\UnitTestCase;

/**
 * @package HappyFeet
 * @subpackage Domain_Model_Test
 */
class FootnoteTest extends UnitTestCase
{

    /**
     * @var Footnote
     */
    protected $footnote;

    /**
     *
     */
    public function setUp(): void
    {
        $this->footnote = new Footnote();
    }

    /**
     * @test
     */
    public function shouldSetTitle()
    {
        $this->footnote->setTitle('Dummy title');
        $this->assertEquals('Dummy title', $this->footnote->getTitle());
    }

    /**
     * @test
     */
    public function shouldSetDescription()
    {
        $this->footnote->setDescription('Dummy Description');
        $this->assertEquals('Dummy Description', $this->footnote->getDescription());
    }

    /**
     * @test
     */
    public function shouldSetHeader()
    {
        $this->footnote->setHeader('Dummy Header');
        $this->assertEquals('Dummy Header', $this->footnote->getHeader());
    }

    /**
     * @test
     */
    public function shouldSetIndexNumber()
    {
        $this->footnote->setIndexNumber('Dummy IndexNumber');
        $this->assertEquals('Dummy IndexNumber', $this->footnote->getIndexNumber());
    }
}
