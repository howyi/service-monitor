<?php

namespace ServiceMonitor;

class MonitorTest extends \PHPUnit\Framework\TestCase
{
    public function testExecute()
    {
        $monitor = new class extends Monitor {
            public function start(): void { }
        };

        $value = ['type' => 'test'];

        $trueEvent = $this->prophesize(EventInterface::class);
        $trueEvent->isExecutable($value)->willReturn(true)->shouldBeCalledTimes(1);
        $trueEvent->execute($value)->shouldBeCalledTimes(1);
        $monitor->setEvent($trueEvent->reveal());

        $falseEvent = $this->prophesize(EventInterface::class);
        $falseEvent->isExecutable($value)->willReturn(false)->shouldBeCalledTimes(1);
        $monitor->setEvent($falseEvent->reveal());

        $monitor->start();
        $monitor->execute($value);
    }
}
