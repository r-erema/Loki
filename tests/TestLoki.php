<?php

use PHPUnit\Framework\TestCase;

class TestLoki extends TestCase
{

    public function testCantWriteBeforeReadLock()
    {
        $loki = new Loki('file_to_lock');
        $thorBrother = new Loki('file_to_lock');

        $this->assertTrue($loki->readerLock());
        $this->assertFalse($thorBrother->writerLock());
        $loki->unlock();
        $this->assertTrue($thorBrother->writerLock());
    }

}
