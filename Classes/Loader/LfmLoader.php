<?php
/**
 * Created by PhpStorm.
 * User: Lars_Soendergaard
 * Date: 03.03.2016
 * Time: 14:13
 */

namespace LFM\Twigify\Loader;

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class LfmLoader implements \Twig_LoaderInterface
{
    /**
     * @var array<string>
     */
    protected $templatePaths;

    /**
     * @var array<string>
     */
    protected $layoutPaths;

    /**
     * @var array<string>
     */
    protected $partialPaths;

    public function __construct($templatePaths)
    {
        $this->templatePaths = $templatePaths;
    }

    protected function lookupTemplate($name, $from='templatePaths') {
        $lookedIn = [];
        foreach($this->$from as $path) {
            $lookedIn[] = $path;
            $path = rtrim($path, '/');
            $fullPath = $path.'/'.$name;
            if(file_exists($fullPath)) {
                return $fullPath;
            }
        }
        throw new \Twig_Error_Loader('Template '.$name.' not found. Looked in: '.implode(", ", $lookedIn));
    }

    public function getSource($name)
    {
        $path = $this->lookupTemplate($name);
        return file_get_contents($path);
    }

    public function getCacheKey($name)
    {
        return $this->lookupTemplate($name);
    }

    public function isFresh($name, $time)
    {
        $path = $this->lookupTemplate($name);
        $mtime = filemtime($path);
        return $mtime <= $time;
    }
}