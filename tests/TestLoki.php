<?php

use PHPUnit\Framework\TestCase;

class TestLoki extends TestCase
{

    public function testLockFile()
    {
        $loki = new Loki('file_to_lock');
        $thorBrother = new Loki('file_to_lock');

        $this->assertTrue($loki->readerLock());
        $this->assertFalse($thorBrother->writerLock());

        $this->assertTrue($thorBrother->readerLock());
        $this->assertFalse($loki->writerLock());

        $this->assertTrue($loki->unlock());
        $this->assertTrue($thorBrother->writerLock());
    }

}
