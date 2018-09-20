<?php

use org\bovigo\vfs\vfsStream,
    PHPUnit\Framework\TestCase;

class TestLoki extends TestCase
{

    public function testCantWriteBeforeReadLock()
    {
        $file = vfsStream::newFile('file_to_lock');
        vfsStream::setup()->addChild($file);
        $fileName = $file->url();

        $loki = new Loki($fileName);
        $thorBrother = new Loki($fileName);
        $dcSucks = new Loki($fileName);

        $this->assertTrue($loki->readerLock());
        $this->assertTrue($dcSucks->readerLock());
        $this->assertFalse($thorBrother->writerLock());

        $loki->unlock();
        $dcSucks->unlock();
        $this->assertTrue($thorBrother->writerLock());
    }

}
