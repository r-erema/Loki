<?php

    use org\bovigo\vfs\vfsStream;
    use PHPUnit\Framework\TestCase;

class TestLoki extends TestCase
{

    public function testCantWriteBeforeReadLock()
    {
        $file = vfsStream::newFile('file_to_lock');
        vfsStream::setup()->addChild($file);

        $loki = new Loki($file->url());
        $thorBrother = new Loki($file->url());
        $dcSucks = new Loki($file->url());

        $this->assertTrue($loki->readerLock());
        $this->assertTrue($dcSucks->readerLock());
        $this->assertFalse($thorBrother->writerLock());

        $loki->unlock();
        $dcSucks->unlock();
        $this->assertTrue($thorBrother->writerLock());

    }

}
