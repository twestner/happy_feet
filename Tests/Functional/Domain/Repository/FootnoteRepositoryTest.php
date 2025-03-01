<?php
namespace AOE\HappyFeet\Tests\Functional\Domain\Repository;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2021 AOE GmbH <dev@aoe.com>
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
use AOE\HappyFeet\Domain\Repository\FootnoteRepository;
use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use stdClass;
use Throwable;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;

/**
 * @package HappyFeet
 * @subpackage Domain_Repository_Test
 */
class FootnoteRepositoryTest extends FunctionalTestCase
{
    /**
     * @var FootnoteRepository
     */
    private $repository;

    /**
     * @var array
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/happy_feet'
    ];

    /**
     *
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->repository = GeneralUtility::makeInstance(FootnoteRepository::class);
        $this->repository->initializeObject();
    }

    /**
     * (non-PHPdoc)
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->repository);
    }

    /**
     * @test
     */
    public function shouldGetDefaultIndexWhenNoRecordsAvailable()
    {
        $lowestIndex = $this->repository->getLowestFreeIndexNumber();
        $this->assertEquals(1, $lowestIndex);
    }

    /**
     * @test
     */
    public function shouldGetLowestIndex()
    {
        $this->importDataSet(__DIR__ . '/fixtures/tx_happyfeet_domain_model_footnote.xml');
        $lowestIndex = $this->repository->getLowestFreeIndexNumber();
        $this->assertEquals(1, $lowestIndex);
    }

    /**
     * @test
     */
    public function shouldGetIndexWithGap()
    {
        $this->importDataSet(__DIR__ . '/fixtures/tx_happyfeet_domain_model_footnote_gap.xml');
        $lowestIndex = $this->repository->getLowestFreeIndexNumber();
        $this->assertEquals(2, $lowestIndex);
    }

    /**
     * @test
     */
    public function shouldGetNextIndexInRow()
    {
        $this->importDataSet(__DIR__ . '/fixtures/tx_happyfeet_domain_model_footnote_row.xml');
        $lowestIndex = $this->repository->getLowestFreeIndexNumber();
        $this->assertEquals(3, $lowestIndex);
    }

    /**
     * @test
     */
    public function shouldGetFootnoteByUid()
    {
        $this->importDataSet(__DIR__ . '/fixtures/tx_happyfeet_domain_model_footnote.xml');
        $footnote = $this->repository->getFootnoteByUid(1);
        $this->assertInstanceOf(Footnote::class, $footnote);
        $this->assertEquals(1, $footnote->getUid());
    }

    /**
     * @test
     */
    public function shouldReturnNullIfFootnoteNotFound()
    {
        $this->importDataSet(__DIR__ . '/fixtures/tx_happyfeet_domain_model_footnote.xml');
        $footnote = $this->repository->getFootnoteByUid(99);
        $this->assertNull($footnote);
    }

    /**
     * @test
     */
    public function shouldGetFootnotesByUids()
    {
        $this->importDataSet(__DIR__ . '/fixtures/tx_happyfeet_domain_model_footnote_collection.xml');
        $footnotes = $this->repository->getFootnotesByUids([2, 4]);
        $this->assertCount(2, $footnotes);
        $this->assertEquals(2, $footnotes[0]->getUid());
        $this->assertEquals(4, $footnotes[1]->getUid());
    }

    /**
     * @test
     */
    public function shouldSortFootnotesByGivenOrderOfUids()
    {
        $this->importDataSet(__DIR__ . '/fixtures/tx_happyfeet_domain_model_footnote_collection.xml');
        $footnotes = $this->repository->getFootnotesByUids([4, 1, 5, 3, 2]);
        $this->assertCount(5, $footnotes);
        $this->assertEquals(4, $footnotes[0]->getUid());
        $this->assertEquals(1, $footnotes[1]->getUid());
        $this->assertEquals(5, $footnotes[2]->getUid());
        $this->assertEquals(3, $footnotes[3]->getUid());
        $this->assertEquals(2, $footnotes[4]->getUid());
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWithInvalidObject()
    {
        $this->expectException(IllegalObjectTypeException::class);

        $footnote = new stdClass();
        $this->repository->add($footnote);
    }

    /**
     * @test
     * assert that no exception is thrown
     */
    public function shouldAddObject()
    {
        try {
            $footnote = new Footnote();
            $this->repository->add($footnote);
        } catch (Throwable $notExpected) {
            $this->fail('assert that no exception is thrown.');
        }

        $this->assertTrue(true);
    }
}
