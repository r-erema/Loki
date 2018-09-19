<?php

class Loki
{

    /**
     * @var string
     */
    private $fileName;

    /**
     * @var bool|resource
     */
    private $file;

    /**
     * Loki constructor.
     * @param string $fileName
     */
    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
        $this->file = fopen($this->fileName, 'c');
    }

    /**
     * @return bool
     */
    public function readerLock(): bool
    {
        return flock($this->file, LOCK_SH);
    }

    /**
     * @param bool $blockUntilUnlock
     * @return bool
     */
    public function writerLock(bool $blockUntilUnlock = false): bool
    {
        return flock($this->file, LOCK_EX | ($blockUntilUnlock ? 0 : LOCK_NB));
    }

    /**
     * @return bool
     */
    public function unlock(): bool
    {
        return flock($this->file, LOCK_UN);
    }

}