<?php
namespace AOE\HappyFeet\Service;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2020 AOE GmbH <dev@aoe.com>
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

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use UnexpectedValueException;

/**
 * Render Footnotes for FCE
 *
 * @package HappyFeet
 * @subpackage Service
 */
class FCEFootnoteService
{
    /**
     * @var RenderingService
     */
    private $renderingService;

    /**
     * @var ContentObjectRenderer
     */
    public $cObj;

    /**
     * @param RenderingService $renderingService
     */
    public function __construct(RenderingService $renderingService)
    {
        $this->renderingService = $renderingService;
    }

    /**
     *
     * @param string $content
     * @param array $conf optional (this will be automatically set, of this method is called via 'TYPOSCRIPT-userFunc')
     * @return string The wrapped index value
     * @throws UnexpectedValueException
     */
    public function renderItemList($content, $conf = array())
    {
        if (false === array_key_exists('userFunc', $conf) || false === array_key_exists('field', $conf)) {
            return '';
        }
        if (array_key_exists('isGridElement', $conf) && (boolean)$conf['isGridElement'] === true) {
            $footnoteUids = $this->getCObj()->data['pi_flexform']['data']['sDEF']['lDEF'][$conf['field']]['vDEF'];
        } else {
            $footnoteUids = $this->getCObj()->getCurrentVal();
        }
        if (empty($footnoteUids)) {
            return '';
        }
        return $this->renderingService->renderFootnotes(explode(',', $footnoteUids));
    }

    /**
     * @return ContentObjectRenderer
     * @throws UnexpectedValueException
     */
    protected function getCObj()
    {
        if (!$this->cObj instanceof ContentObjectRenderer) {
            throw new UnexpectedValueException('cObj was not set', 1393843943);
        }
        return $this->cObj;
    }

    /**
     * @param ContentObjectRenderer $cObj
     */
    public function setCObj(ContentObjectRenderer $cObj)
    {
        $this->cObj = $cObj;
    }
}
