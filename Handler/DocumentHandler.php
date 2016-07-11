<?php

namespace Maven\Bundle\MagentoBundle\Handler;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Class DocumentHandler
 *
 * @package Maven\Bundle\MagentoBundle\Handler
 */
class DocumentHandler
{
    /**
     * @var string
     */
    protected $webPath;

    /**
     * @var string
     */
    protected $absPath;

    /**
     * @var string
     */
    protected $filePath;

    /**
     * DocumentHandler constructor.
     *
     * @param string $webPath
     * @param string $absPath
     */
    public function __construct($webPath, $absPath)
    {
        $this->webPath = $webPath;
        $this->absPath = $absPath;
    }

    /**
     * @param string $content
     * @param string $fileExtension
     *
     * @return string
     * @throws \Exception
     */
    public function write($content, $fileExtension)
    {
        $fs = new Filesystem();
        $name = $this->getUniqueWebName($fileExtension);
        $this->setFileDir($name);

        try {
            $fs->dumpFile($this->filePath, $content);

            return $name;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $name
     *
     * @return $this
     */
    private function setFileDir($name)
    {
        $this->filePath = $this->absPath . DIRECTORY_SEPARATOR .  $name;

        return $this;
    }

    /**
     * @param $fileExtension
     *
     * @return string
     */
    private function getUniqueWebName($fileExtension)
    {
        $fileExtension = strtolower($fileExtension);

        return $this->webPath . DIRECTORY_SEPARATOR . md5(uniqid()).".".$fileExtension;
    }
}
